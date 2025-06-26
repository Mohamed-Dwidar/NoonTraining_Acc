<?php

namespace Modules\StudentModule\Repository;

use Modules\StudentModule\app\Http\Models\Student;
use Prettus\Repository\Eloquent\BaseRepository;

class StudentRepository extends BaseRepository
{
    function model()
    {
        return Student::class;
    }

    public function filter(array $request)
    {
        return Student::filter($request);
    }

    function getByIds($ids)
    {
        return Student::whereIN('id', $ids)->get();
    }

    function getField($id, $field)
    {
        $student =  Student::where('id', $id)->first();
        return $student[$field];
    }

    function updatePassword($id, $newPassword)
    {
        $student = Student::where('id', $id)->first();
        $newPass = bcrypt($newPassword);
        return $student->update(['password' => $newPass]);
    }

    function findAllWithActions($arr_actions = [])
    {
        // $query = Student::where('students.id', '>=', 1);
        $query = Student::select('students.*');

        if (!empty($arr_actions)) {
            //Search By///
            if (key_exists('search_by', $arr_actions)) {
                foreach ($arr_actions['search_by'] as $col => $search_by) {
                    $query->orWhereRaw('UPPER(' . $col . ') LIKE "%' . strtoupper($search_by) . '%"');
                }
            }
            ////////////
            //Order By///
            if (key_exists('order_by', $arr_actions)) {
                foreach ($arr_actions['order_by'] as $col => $order_by) {
                    $query->orderBy($col, $order_by);
                }
            }
            ////////////

            if (key_exists('trashed', $arr_actions)) {
                $query->onlyTrashed();
            }


            // $query->join('specialities', 'students.speciality_id', '=', 'specialities.id');
            // $query->join('users', 'students.user_id', '=', 'users.id');
            // $query->leftJoin('users', function ($join) {
            //     $join->on('students.user_id', '=', 'users.id');
            // });
        }

        return $query->paginate(20);
    }

    public function restore($id)
    {
        Student::withTrashed()->find($id)->restore();
    }  

    public function deleteStudentFromArchive($id)
    {
        Student::onlyTrashed()->find($id)->forceDelete();
    }  

    
}
