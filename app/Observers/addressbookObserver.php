<?php

namespace App\Observers;

use App\Models\addressbook;
use App\Models\history;
use DB;

class addressbookObserver
{
    /**
     * Handle the addressbook "created" event.
     *
     * @param  \App\Models\addressbook  $addressbook
     * @return void
     */
    public function created(addressbook $addressbook)
    {
        $body = 'create record : '.$addressbook->email;
        history::create([
            'reference_table' => $addressbook->getTable(),
            'action'    => 'create',
            'body' => $body
        ]);
    }

    /**
     * Handle the addressbook "updated" event.
     *
     * @param  \App\Models\addressbook  $addressbook
     * @return void
     */
    public function updated(addressbook $addressbook)
    {
        
        $body = 'update record : '.$addressbook->email;

        history::create([
            'reference_table' => $addressbook->getTable(),
            'reference_id' => $addressbook->id,
            'action'    => 'update',
            'body' => $body
        ]);
        
        
    }

    /**
     * Handle the addressbook "deleted" event.
     *
     * @param  \App\Models\addressbook  $addressbook
     * @return void
     */
    public function deleted(addressbook $addressbook)
    {
        $body = 'Deleted record : '.$addressbook->email;
        history::create([
            'reference_table' => $addressbook->getTable(),
            'reference_id' => $addressbook->id,
            'action'    => 'delete',
            'body' => $body
        ]);
    }

    /**
     * Handle the addressbook "restored" event.
     *
     * @param  \App\Models\addressbook  $addressbook
     * @return void
     */
    public function restored(addressbook $addressbook)
    {
        //
    }

    /**
     * Handle the addressbook "force deleted" event.
     *
     * @param  \App\Models\addressbook  $addressbook
     * @return void
     */
    public function forceDeleted(addressbook $addressbook)
    {
        //
    }
}
