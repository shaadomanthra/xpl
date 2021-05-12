<?php

namespace PacketPrep\Models\Mailer;

use Illuminate\Database\Eloquent\Model;

class MailEvent extends Model
{
    protected $table = 'mailevent';
    protected $fillable = [
        'name',
        'subject',
        'message',
        'emails',
        'status',
        // add all other fields
    ];

    public function maillog()
    {
        return $this->hasMany('PacketPrep\Models\Mailer\MailLog','mailevent_id');
    }
}
