<?php

namespace App\Services\Admin;

use App\Models\MailTemplate;
use App\Models\Service;


class MailService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        return MailTemplate::where(function($query) use ($filters) {
            if (hasInput($filters['name'] ?? '')) {
                $query->where('mail_templates.name', 'LIKE', '%' . $filters['name'] . '%');
            }
        })
            ->sorting(['mail_templates.name'], 'mail_templates.id')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $mailId
     * @return mixed
     */
    public function getById(int $mailId): mixed
    {
        return MailTemplate::find($mailId);
    }

    /**
     * Update specific record to database.
     *
     * @param int $mailId
     * @param array $data
     * @return void
     */
    public function update(int $mailId, array $data)
    {
        MailTemplate::where('id', $mailId)->update($data);
    }




}
