<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth; //追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //認証済みユーザーの場合
        if(Auth::check()){
            //認証済みユーザーを獲得
            $user = Auth::user();

            // タスク一覧を取得
            // $tasks = Task::orderby('id', 'asc')->paginate(25);
            $tasks = $user->tasks()->orderby('id', 'asc')->paginate(10);

            // タスク一覧ビューでそれを表示
            return view('tasks.index', ['tasks' => $tasks]);
        }
        else{
            return view('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
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
            'status' => 'required|max:10',
            'content' => 'required',
        ]);
        //タスクを作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->user_id = Auth::user()->id; //追加
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //認証済みユーザーを確認
        if(Auth::check()){
            //idの値でタスクを検索して取得
            $task = task::findOrFail($id);

            //認証済みユーザーとタスクの所有者の一致確認
            if(Auth::id() == $task->user_id){
                // タスク詳細ビューでそれを表示
                return view('tasks.show', [
                    'task' => $task,
                ]);
            }
            else{
                // トップページへリダイレクトさせる
                return redirect('/');
            }
        }
        else{
            // トップページへリダイレクトさせる
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //認証済みユーザーを確認
        if(Auth::check()){
            //idの値でタスクを検索して取得
            $task = Task::findOrFail($id);

            //認証済みユーザーとタスクの所有者の一致確認
            if(Auth::id() == $task->user_id){
            // タスク編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
            ]);
            }
            else{
                // トップページへリダイレクトさせる
                return redirect('/');
            }
        }
        else{
            // トップページへリダイレクトさせる
            return redirect('/');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //認証済みユーザーを確認
        if(Auth::check()){
            //バリデーション
            $request->validate([
                'status' => 'required|max:10',
                'content' => 'required',
            ]);

            //idの値でタスクを検索して取得
            $task = Task::findOrFail($id);

            //認証済みユーザーとタスクの所有者の一致確認
            if(Auth::id() == $task->user_id){
                // タスクを更新
                $task->status = $request->status;
                $task->content = $request->content;
                $task->save();

                // トップページへリダイレクトさせる
                return redirect('/');
            }
            else{
                // トップページへリダイレクトさせる
                return redirect('/');
            }
        }
        else{
            // トップページへリダイレクトさせる
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //認証済みユーザーを確認
        if(Auth::check()){
            //// idの値でタスクを検索して取得
            $task = Task::findOrFail($id);

            //認証済みユーザーとタスクの所有者の一致確認
            if(Auth::id() == $task->user_id){
                // タスクを削除
                $task->delete();

                // トップページへリダイレクトさせる
                return redirect('/');
            }
            else{
                // トップページへリダイレクトさせる
                return redirect('/');
            }
        }
        else{
            // トップページへリダイレクトさせる
            return redirect('/');
        }
    }
}
