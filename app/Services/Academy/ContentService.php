<?php
namespace App\Services\Academy;
use App\Models\Academy\{Package, PackageModule, Lesson, LessonStep, LessonAsset};
use App\Models\AdminAuditLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
class ContentService
{
    public function __construct(private VideoUrlService $videoUrl) {}
    public function createPackage(array $data): Package
    {
        $pkg = Package::create($data);
        AdminAuditLog::record('package.created', $pkg);
        return $pkg;
    }
    public function updatePackage(Package $pkg, array $data): Package
    {
        $wasPublished = $pkg->is_published;
        $pkg->update($data);
        $action = (!$wasPublished && $pkg->is_published) ? 'package.published' : 'package.updated';
        AdminAuditLog::record($action, $pkg);
        return $pkg;
    }
    public function deletePackage(Package $pkg): void
    {
        AdminAuditLog::record('package.deleted', $pkg, ['title' => $pkg->title]);
        $pkg->delete();
    }
    public function createModule(Package $pkg, array $data): PackageModule
    {
        $module = $pkg->modules()->create($data);
        AdminAuditLog::record('module.created', $module);
        return $module;
    }
    public function updateModule(PackageModule $module, array $data): PackageModule
    {
        $module->update($data);
        AdminAuditLog::record('module.updated', $module);
        return $module;
    }
    public function deleteModule(PackageModule $module): void
    {
        AdminAuditLog::record('module.deleted', $module, ['title' => $module->title]);
        $module->delete();
    }
    public function createLesson(PackageModule $module, array $data): Lesson
    {
        $lesson = $module->lessons()->create($data);
        AdminAuditLog::record('lesson.created', $lesson);
        return $lesson;
    }
    public function updateLesson(Lesson $lesson, array $data): Lesson
    {
        $wasPublished = $lesson->is_published;
        $lesson->update($data);
        $action = (!$wasPublished && $lesson->is_published) ? 'lesson.published' : 'lesson.updated';
        AdminAuditLog::record($action, $lesson);
        return $lesson;
    }
    public function deleteLesson(Lesson $lesson): void
    {
        AdminAuditLog::record('lesson.deleted', $lesson, ['title' => $lesson->title]);
        $lesson->delete();
    }
    public function reorderLessons(PackageModule $module, array $orderedIds): void
    {
        foreach ($orderedIds as $i => $id) {
            $module->lessons()->where('id', $id)->update(['sort_order' => $i]);
        }
    }
    public function syncSteps(Lesson $lesson, array $steps): void
    {
        $lesson->steps()->delete();
        foreach ($steps as $i => $step) {
            $lesson->steps()->create([
                'title'       => $step['title'],
                'description' => $step['description'] ?? null,
                'nav_path'    => $step['nav_path'] ?? null,
                'sort_order'  => $i,
            ]);
        }
    }
    public function initiateVideoUpload(Lesson $lesson, string $filename, string $mimeType): array
    {
        $s3Key     = $this->videoUrl->generateS3Key($lesson->id, $filename);
        $presigned = $this->videoUrl->presignedUploadUrl($s3Key, $mimeType);
        $asset = LessonAsset::updateOrCreate(
            ['lesson_id' => $lesson->id, 'type' => 'video'],
            ['label' => $filename, 's3_key' => $s3Key, 'mime_type' => $mimeType, 'sort_order' => 0]
        );
        return array_merge($presigned, ['asset_id' => $asset->id]);
    }
    public function confirmVideoUpload(LessonAsset $asset, int $fileSizeBytes, int $durationSeconds = 0): void
    {
        $asset->update(['file_size_bytes' => $fileSizeBytes, 'duration_seconds' => $durationSeconds]);
        $asset->lesson->update(['duration_seconds' => $durationSeconds]);
        AdminAuditLog::record('video.uploaded', $asset, ['lesson_id' => $asset->lesson_id, 's3_key' => $asset->s3_key]);
    }
    public function deleteAsset(LessonAsset $asset): void
    {
        if ($asset->s3_key) Storage::disk('s3')->delete($asset->s3_key);
        AdminAuditLog::record('asset.deleted', $asset);
        $asset->delete();
    }
}
