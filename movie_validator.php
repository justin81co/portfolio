<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


/**
 * Class FormController
 * @package App\Http\Controllers
 */
class FormController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('pages.form.show');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'bail|required|max:255',
            'header_line' => 'bail|required|max:1024',
            'stars' => 'nullable|numeric|min:1|max:5'
            ]);
        
    }
}
?>
