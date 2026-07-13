<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingImageController extends Controller
{
    public function index()
    {
        $images = LandingImage::all()->groupBy('section');
        return view('admin.images.index', compact('images'));
    }

    public function update(Request $request, LandingImage $landingImage)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'uploads/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), basename($filename));

            // Optional: delete old file if it is in uploads directory
            if (Str::contains($landingImage->path, 'uploads/') && file_exists(public_path($landingImage->path))) {
                @unlink(public_path($landingImage->path));
            }

            $landingImage->update([
                'path' => 'images/uploads/' . basename($filename)
            ]);
        }

        return back()->with('success', 'Imagem atualizada com sucesso!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'title' => 'required|string|max:255',
            'section' => 'nullable|string|in:portfolio,banner',
        ]);

        $section = $request->input('section', 'portfolio');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'uploads/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads'), basename($filename));

            $key = $section . '_' . uniqid();

            LandingImage::create([
                'key' => $key,
                'title' => $request->input('title'),
                'path' => 'images/uploads/' . basename($filename),
                'section' => $section,
            ]);
        }

        return back()->with('success', 'Nova imagem adicionada!');
    }

    public function destroy(LandingImage $landingImage)
    {
        // Allow deleting gallery/portfolio or banners (but protect original default if desired; here we let the user manage it)
        if (!in_array($landingImage->section, ['portfolio', 'banner'])) {
            return back()->with('error', 'Apenas imagens da galeria ou banners adicionais podem ser removidos.');
        }

        if (Str::contains($landingImage->path, 'uploads/') && file_exists(public_path($landingImage->path))) {
            @unlink(public_path($landingImage->path));
        }

        $landingImage->delete();

        return back()->with('success', 'Imagem removida com sucesso!');
    }
}
