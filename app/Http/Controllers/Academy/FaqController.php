<?php
namespace App\Http\Controllers\Academy;
use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get()->groupBy('category');
        return view('academy.faq', compact('faqs'));
    }
}
