<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // メッセージ一覧を取得
        $tasks = Task::all();

        // メッセージ一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);         
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'task' => 'required|max:255',
            'content' => 'required|max:255',
        ]);
        //メッセージを作成
        $task = new Task;
        $task->title = $request->title;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //idの値でメッセージを検索して取得
        $task = task::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージを更新
        $task->title = $request->title;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //// idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
