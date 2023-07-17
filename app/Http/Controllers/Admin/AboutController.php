<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\FrequentlryQuestions;
use App\Models\Privacy;
use App\Models\TermsAndConditions;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    private $aboutModel, $termModel, $questionsModel, $privceModel;
    public function __construct(About $about, TermsAndConditions $term, FrequentlryQuestions $questions, Privacy $privce)
    {
        $this->aboutModel = $about;
        $this->termModel = $term;
        $this->questionsModel = $questions;
        $this->privceModel = $privce;
    }

    public function about()
    {
        $about = $this->aboutModel::orderBy('id', 'DESC')->first();
        return view('Admin.about', compact('about'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
        ]);

        $this->aboutModel::create([
            'about_ar' => $request->desc_ar,
            'about_en' => $request->desc_en,
            'about_tr' => $request->desc_tr
        ]);

        return back()->with('done', __('dashboard.addAboutMessage'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'aboutId' => 'required|exists:abouts,id',
            'about_ar' => 'required|string',
            'about_en' => 'required|string',
            'about_tr' => 'required|string',
        ]);
        $about = $this->aboutModel::find($request->aboutId);
        $about->update([
            'about_ar' => $request->about_ar,
            'about_en' => $request->about_en,
            'about_tr' => $request->about_tr
        ]);

        return back()->with('done', __('dashboard.updateAboutMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'aboutId' => 'required|exists:abouts,id',
        ]);
        $about = $this->aboutModel::find($request->aboutId);
        $about->delete();

        return back()->with('done', __('dashboard.deleteAboutMessage'));
    }


    public function terms()
    {
        $term = $this->termModel::orderBy('id', 'DESC')->first();
        return view('Admin.terms', compact('term'));
    }


    public function storeterms(Request $request)
    {
        $request->validate([
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
        ]);

        $this->termModel::create([
            'term_ar' => $request->desc_ar,
            'term_en' => $request->desc_en,
            'term_tr' => $request->desc_tr
        ]);

        return back()->with('done', __('dashboard.addAboutMessage'));
    }

    public function updateterms(Request $request)
    {
        $request->validate([
            'aboutId' => 'required|exists:terms_and_conditions,id',
            'about_ar' => 'required|string',
            'about_en' => 'required|string',
            'about_tr' => 'required|string',
        ]);
        $about = $this->termModel::find($request->aboutId);
        $about->update([
            'term_ar' => $request->about_ar,
            'term_en' => $request->about_en,
            'term_tr' => $request->about_tr
        ]);

        return back()->with('done', __('dashboard.updateAboutMessage'));
    }
    public function deleteterms(Request $request)
    {
        $request->validate([
            'aboutId' => 'required|exists:terms_and_conditions,id',
        ]);
        $about = $this->termModel::find($request->aboutId);
        $about->delete();

        return back()->with('done', __('dashboard.deleteAboutMessage'));
    }

    public function questions()
    {
        $questions = $this->questionsModel::orderBy('id', 'DESC')->get();
        return view('Admin.questions', compact('questions'));
    }


    public function storequestions(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $this->questionsModel::create([
            'title_ar' => $request->question,
            'title_en' => $en->translate($request->question),
            'title_tr' => $tr->translate($request->question),
            'answer_ar' => $request->answer,
            'answer_en' => $en->translate($request->answer),
            'answer_tr' => $tr->translate($request->answer),
        ]);

        return back()->with('done', 'تم اضافة السؤال بنجاح');
    }

    public function updatequestions(Request $request)
    {
        $request->validate([
            'socialId' => 'required|exists:frequentlry_questions,id',
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        $about = $this->questionsModel::find($request->socialId);
        $tr = new GoogleTranslate('tr');
        $en = new GoogleTranslate('en');
        $about->update([
            'title_ar' => $request->question,
            'title_en' => $en->translate($request->question),
            'title_tr' => $tr->translate($request->question),
            'answer_ar' => $request->answer,
            'answer_en' => $en->translate($request->answer),
            'answer_tr' => $tr->translate($request->answer),
        ]);

        return back()->with('done', 'تم تعديل السؤال');
    }
    public function deletequestions(Request $request)
    {
        $request->validate([
            'socialId' => 'required|exists:frequentlry_questions,id',
        ]);
        $about = $this->termModel::find($request->socialId);
        $about->delete();

        return back()->with('done', 'تم حذف السؤال');
    }

    public function privacies()
    {
        $about = $this->privceModel::orderBy('id', 'DESC')->first();
        return view('Admin.privacies', compact('about'));
    }
    public function storeprivacies(Request $request)
    {
        $request->validate([
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
        ]);

        $this->privceModel::create([
            'about_ar' => $request->desc_ar,
            'about_en' => $request->desc_en,
            'about_tr' => $request->desc_tr
        ]);

        return back()->with('done', __('dashboard.addAboutMessage'));
    }

    public function updateprivacies(Request $request)
    {
        $request->validate([
            'aboutId' => 'required|exists:privacies,id',
            'about_ar' => 'required|string',
            'about_en' => 'required|string',
            'about_tr' => 'required|string',
        ]);
        $about = $this->privceModel::find($request->aboutId);
        $about->update([
            'privace_ar' => $request->about_ar,
            'privace_en' => $request->about_en,
            'privace_tr' => $request->about_tr
        ]);

        return back()->with('done', 'تم تحديث الخصوصية');
    }

    public function deleteprivacies(Request $request)
    {
        $request->validate([
            'aboutId' => 'required|exists:privacies,id',
        ]);
        $about = $this->aboutModel::find($request->aboutId);
        $about->delete();

        return back()->with('done', __('dashboard.deleteAboutMessage'));
    }
}
