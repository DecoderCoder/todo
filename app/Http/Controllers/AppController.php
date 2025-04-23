<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\ToDoes;

class AppController extends Controller
{
    const placeholders = [
        'e.g., Buy groceries',
        'e.g., Call the dentist',
        'e.g., Finish the report',
        'e.g., Walk the dog',
        'e.g., Pay electricity bill',
        'e.g., Book flight tickets',
        'e.g., Read 10 pages of a book',
        'e.g., Water the plants',
        'e.g., Schedule team meeting',
        'e.g., Clean the kitchen',
    ];

    const RedirectTo = 'app.index';

    private function fixParents(&$target, $todoes)
    {
        $arr = [];

        foreach ($todoes as $todo) {
            if ($todo['parent'] == $target['id']) {
                $children = $this->fixParents($todo, $todoes);
                if ($children) {
                    $todo['child'] = $children;
                }
                $arr[] = $todo;
            }
        }
        return $arr;
    }

    public function index()
    {
        $todoes = ToDoes::all()->toArray();
        $arr = [];
        foreach ($todoes as &$todo) {
            if ($todo['parent'] == null || $todo['parent'] == 0) {
                $todo['child'] = $this->fixParents($todo, $todoes);
                $arr[] = $todo;
            }

        }
        $todoes = $arr;
        return view('layouts.app', ['todoes' => $todoes, 'placeholder' => self::placeholders[array_rand(self::placeholders, 1)]]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:1',
            'parent' => ''
        ]);

        $todo = new ToDoes(); // I know that I missed naming of the table, but it was too late...
        $todo['name'] = $validated['name'];
        $todo['parent'] = $validated['parent'];
        $todo->save();

        return redirect()->route(self::RedirectTo);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => '',
            'parent' => ''
        ]);

        $todo = ToDoes::find($validated['id']);
        if (!empty($todo)) {
            $todo['name'] = $validated['name'];
            $todo['description'] = $validated['description'] ?? '';
            $todo['parent'] = $validated['parent'];
            $todo->save();
        }

        return redirect()->route(self::RedirectTo);
    }

    public function switchCompleted($id){
        print_r($id);
        $todo = ToDoes::find($id);
        $todo['completed'] = !$todo['completed'];
        $todo->save();

        return redirect()->route(self::RedirectTo);
    }

    public function delete($id)
    {
        ToDoes::where('parent', $id)->update(['parent' => 0]);
        ToDoes::find($id)->delete();

        return redirect()->route(self::RedirectTo);
    }
}
