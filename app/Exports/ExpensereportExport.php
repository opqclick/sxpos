<?php

namespace App\Exports;


use App\Models\Expense;
use App\Models\ExpenseCategory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpensereportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $data = Expense::where('created_by', \Auth::user()->creatorId())->get();
        foreach ($data as $k => $expense) {
            $expensecategory = Expense::expensecategory($expense->category_id);

            unset($expense->updated_at, $expense->created_at, $expense->id, $expense->branch_id, $expense->category_id);

            $data[$k]["name"] = $expensecategory;

        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "Date",
            "Amount",
            "Note",
            "Created By",
            "Expense Category",

        ];

    }
}