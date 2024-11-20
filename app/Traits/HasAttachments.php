<?php

namespace App\Traits;

use App\Events\AttachmentEvent;
use Illuminate\Support\Facades\Storage;
use Tecdiary\Laravel\Attachments\HasAttachment;

trait HasAttachments
{
    use HasAttachment;

    public function moveAttachments($attachments)
    {
        if ($attachments) {
            foreach ($attachments as $attachment) {
                if (Storage::disk('local')->exists($attachment['path'])) {
                    $this->attach(
                        Storage::disk('local')->path($attachment['path']),
                        [
                            'title' => $attachment['name'],
                            'disk'  => env('ATTACHMENT_DISK', 'local'),
                        ]
                    );
                    Storage::disk('local')->delete($attachment['path']);
                }
            }
        }
    }

    public function saveAttachments($attachments)
    {
        $existingAttachments = $this->attachments()->pluck('filename', 'key') ? $this->attachments()->pluck('filename', 'key')->toArray() : [];
        if ($attachments) {
            $files = [];
            foreach ($attachments as $attachment) {
                if(!in_array($attachment->getClientOriginalName(), $existingAttachments)) {
                    $files[] = [
                        'name' => $attachment->getClientOriginalName(),
                        'path' => Storage::disk('local')->put('attachments', $attachment),
                    ];
                }
                // $files[] = ['name' => $attachment->getClientOriginalName(), 'path' => $attachment->store('attachments', 'local')];
            }
            $attachmentsCollect = array_map(function($atm) {
                return $atm->getClientOriginalName();
            }, $attachments);

            foreach($existingAttachments as $key => $fileName) {
                if(!in_array($fileName, $attachmentsCollect)) {
                    $this->attachment($key)->delete();
                }
            }
            event(new AttachmentEvent($this, $files));
        } else if(!empty($existingAttachments)) {
            foreach($existingAttachments as $key => $fileName) {
                $this->attachment($key)->delete();
            }
        }
    }
}
