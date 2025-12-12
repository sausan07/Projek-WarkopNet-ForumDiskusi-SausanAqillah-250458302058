<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Auth;

class ReportButton extends Component
{
    public $threadId = null;
    public $postId = null;
    public $showModal = false;
    public $reason = '';

    // notif
    public $showNotif = false;
    public $notifMessage = '';
    public $notifType = 'success';

    // FIX: cegah toast muncul saat pertama kali buka halaman
    public $ready = false;

    protected $rules = [
        'reason' => 'required|string|min:10|max:500',
    ];

    public function mount()
    {
        $this->ready = true;
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->reason = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset('reason');
        $this->resetValidation();
    }

    public function submitReport()
    {
        $this->validate();

        // Cek sudah melapor
        $reportin = Report::where('user_id', Auth::id())
            ->where(function($q) {
                if ($this->threadId) $q->where('thread_id', $this->threadId);
                if ($this->postId) $q->where('post_id', $this->postId);
            })
            ->first();

        if ($reportin) {
            $this->triggerNotif('Anda sudah melaporkan konten ini.', 'error');
            $this->closeModal();
            return;
        }

        // Buat laporan
        Report::create([
            'user_id' => Auth::id(),
            'thread_id' => $this->threadId,
            'post_id' => $this->postId,
            'reason' => $this->reason,
            'status' => 'pending',
        ]);

        $this->triggerNotif('Laporan berhasil dikirim. Terima kasih!', 'success');

        $this->closeModal();
        $this->dispatch('report-submitted');
    }

    public function triggerNotif($message, $type = 'success')
    {
        $this->notifMessage = $message;
        $this->notifType = $type;
        $this->showNotif = true;

        $this->dispatch('hide-notif');


    }

    #[On('hide-notif')]
    public function hideNotif()
    {
        $this->showNotif = false;
    }

    public function render()
    {
        return view('livewire.report-button');
    }
}
