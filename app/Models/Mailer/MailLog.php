<?php

namespace PacketPrep\Models\Mailer;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $table = 'maillog';
    protected $fillable = [
        'name',
        'message',
        'email',
        'status',
        'mailevent_id',
        'message_id',
        // add all other fields
    ];
}
