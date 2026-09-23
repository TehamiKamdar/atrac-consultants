<?php

namespace App\Http\Controllers\Admin;

use App\Models\contacts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
public function index()
{
    $promoKeywords = [
        'seo',
        'backlink',
        'guest post',
        'traffic',
        'ranking',
        'marketing',
        'promotion',
        'offer',
        'deal',
        'advertisement',
        'digital marketing',
        'sales',
        'boost'
    ];

    $contacts = contacts::query()

        // ❌ Exclude subject containing atracconsultants.com
        ->where('subject', 'NOT LIKE', '%atracconsultants.com%')

        // ❌ Exclude promotional content in message
        ->where(function ($query) use ($promoKeywords) {
            foreach ($promoKeywords as $word) {
                $query->where('message', 'NOT LIKE', '%' . $word . '%');
            }
        })

        ->latest()
        ->get();

    return view('admin.contact.index', compact('contacts'));
}

}
