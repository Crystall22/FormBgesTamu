<?php
namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function create()
    {
        return view('queue');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'customer_id' => 'required|string|max:20',
        ]);

        $queueNumber = Queue::max('queue_number') + 1;

        $queue = Queue::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'customer_id' => $request->customer_id,
            'queue_number' => $queueNumber,
        ]);

        return redirect()->route('queue.show', $queue->id);
    }

    public function show(Queue $queue)
    {
        return view('queue-number', compact('queue'));
    }

    public function index()
    {
        $queues = Queue::orderBy('created_at', 'desc')->get();
        return view('customerservice.queue-list', compact('queues'));
    }

    public function destroy($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->delete();

        return redirect()->route('customerservice.queue-list')->with('success', 'Nomor antrian berhasil dihapus.');
    }
}
