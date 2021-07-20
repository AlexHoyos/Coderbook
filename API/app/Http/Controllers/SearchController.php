<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function generalSearch(Request $request, $search){
        $search = urldecode($search);
        // Fragmentamos el query en varias palabras
        $queries = explode(' ', $search);
        $results = [];

        //$raw = DB::raw("id, name, lname, username, CONCAT(name, ' ', lname) AS fullname");
        $users = User::with('profilePic')
            ->where(DB::raw("concat_ws(' ', name, lname)"), 'LIKE', '%'.$search.'%')
            ->orWhere('username', 'LIKE', '%'.$search.'%')
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();
        $pages = Page::with('principalPic')
            ->where('title', 'LIKE', '%'. $search .'%')
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();
        $results['users'] = $users;
        $results['pages'] = $pages;

        return response()->json($results);

    }

}
