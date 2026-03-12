<?php
namespace App\Services\Academy;
use App\Models\Academy\LessonAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class VideoUrlService
{
    public function generateStreamUrl(LessonAsset $asset): string
    {
        if ($asset->type !== 'video' || empty($asset->s3_key)) {
            throw new \InvalidArgumentException('Asset is not a streamable video.');
        }
        return Storage::disk('s3')->temporaryUrl(
            $asset->s3_key,
            now()->addMinutes(15),
            ['ResponseContentDisposition' => 'inline']
        );
    }
    public function presignedUploadUrl(string $s3Key, string $mimeType = 'video/mp4'): array
{
    $s3Client = Storage::disk('s3')->getClient();
    $bucket   = config('filesystems.disks.s3.bucket');
    $command  = $s3Client->getCommand('PutObject', [
        'Bucket'      => $bucket,
        'Key'         => $s3Key,
        'ContentType' => $mimeType,
    ]);
    $request = $s3Client->createPresignedRequest($command, '+60 minutes');
    return [
        'upload_url' => (string) $request->getUri(),
        's3_key'     => $s3Key,
        'expires_at' => now()->addMinutes(60)->toISOString(),
    ];
}
    public function generateS3Key(int $lessonId, string $filename): string
    {
        $ext  = pathinfo($filename, PATHINFO_EXTENSION);
        $safe = Str::slug(pathinfo($filename, PATHINFO_FILENAME));
        return "academy/videos/lesson-{$lessonId}/{$safe}-" . now()->format('YmdHis') . ".{$ext}";
    }
}
