<?php

namespace App\Exports;

use App\Models\ContactPerson;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactPersonExport extends Export implements FromArray, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function array(): array
    {
        $request = (object)$this->request;

        $query = ContactPerson::query();

        if (!empty($request->designation))
            $query->where('designation', 'LIKE', "%$request->designation%");

        if (!empty($request->name))
            $query->where('name', 'LIKE', "%$request->name%");

        if (!empty($request->email))
            $query->where('email', 'LIKE', "%$request->email%");

        if (!empty($request->phone))
            $query->where('mobile', 'LIKE', "%$request->phone%");

        if (!empty($request->ref_by))
            $query->where('ref_by', $request->ref_by);

        $records = $query->orderBy('created', 'DESC')->get();

        $reults = [];
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $reults[] = [
                    'Designation' => $record->designation,
                    'name'        => $record->name,
                    'email'       => $record->email,
                    'mobile'      => $record->mobile,
                    'type'        => $record->ref_by,
                    'created'     => $record->dformat($record->created),
                ];
            }
        }
        return $reults;
    }

    public function headings(): array
    {
        return [
            'Designation',
            'Name',
            'Email',
            'Mobile',
            'Type',
            'Created'
        ];
    }
}
