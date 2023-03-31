<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanDocuments extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'account_no',
        'document_name',
        'document_location',
        'date',
        'collect_by',
        'taken_loan_id',
        'daily_loan_id',
        'special_taken_loan_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'loan_documents';

    protected $casts = [
        'date' => 'date',
    ];

    public function collectBy()
    {
        return $this->belongsTo(User::class, 'collect_by');
    }

    public function takenLoan()
    {
        return $this->belongsTo(TakenLoan::class);
    }
}
