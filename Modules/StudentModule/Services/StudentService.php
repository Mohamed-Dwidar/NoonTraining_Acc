<?php

namespace Modules\StudentModule\Services;

use App\Helpers\UploaderHelper;
use Modules\StudentModule\Repository\StudentRepository;
use Illuminate\Support\Facades\Hash;
use Modules\CourseModule\Repository\CourseRegRepository;

class StudentService
{
    private $studentRepository;
    private $courseRegRepository;

    public function __construct(StudentRepository $studentRepository,CourseRegRepository $courseRegRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->courseRegRepository = $courseRegRepository;
    }

    public function create($data)
    {
        $student_data = [
            'name' => $data->name,
            'branch_id' => $data->branch_id,
            'id_nu' => $data->id_nu,
            'phone1' => $data->phone1,
            'phone2' => $data->phone2,
            'city_id' => $data->city_id,
            'company' => $data->company,
            'email' => $data->email,
            'birthdate' => $data->birthdate,
            'id_expire_date' => $data->id_expire_date,
            'nationality' => $data->nationality,
            'gender' => $data->gender,
            'notes' => $data->notes ?? null
        ];
        $student = $this->studentRepository->create($student_data);
        return $student;
    }

    public function update($data)
    {
        $student_data = [
            'name' => $data->name,
            'branch_id' => $data->branch_id,
            'id_nu' => $data->id_nu,
            'phone1' => $data->phone1,
            'phone2' => $data->phone2,
            'city_id' => $data->city_id,
            'company' => $data->company,
            'email' => $data->email,
            'birthdate' => $data->birthdate,
            'id_expire_date' => $data->id_expire_date,
            'nationality' => $data->nationality,
            'gender' => $data->gender,
            'notes' => $data->notes ?? null
        ];
        return $this->studentRepository->update($student_data, $data->id);
    }

    public function findAll($arr_actions = [])
    {
        $actions = [];
        ///Sort///
        $arr_sorts = ['name_az', 'name_za', 'reg_az', 'reg_za'];
        if (!empty($arr_actions['sort'])) {
            if (in_array($arr_actions['sort'], $arr_sorts)) {
                if ($arr_actions['sort'] == 'name_az') {
                    $sort_by['students.name'] = 'asc';
                } elseif ($arr_actions['sort'] == 'name_za') {
                    $sort_by['students.name'] = 'desc';
                } elseif ($arr_actions['sort'] == 'reg_az') {
                    $sort_by['students.created_at'] = 'asc';
                } elseif ($arr_actions['sort'] == 'reg_za') {
                    $sort_by['students.created_at'] = 'desc';
                }
                $actions['order_by'] = $sort_by;
            }
        }
        /////////

        ///Search///
        if (!empty($arr_actions['search'])) {
            $actions['search_by']['students.name'] = $arr_actions['search'];
            $actions['search_by']['students.email'] = $arr_actions['search'];
            $actions['search_by']['students.id_nu'] = $arr_actions['search'];
            $actions['search_by']['students.phone1'] = $arr_actions['search'];
        }
        ///////////
        return $this->studentRepository->findAllWithActions($actions);
    }

    public function findAllWithFilter(array $request)
    {
        return $this->studentRepository->filter($request);
    }

    public function findOne($id)
    {
        return $this->studentRepository->find($id);
    }

    public function deleteOne($id)
    {
        if ($this->studentRepository->delete($id)) {
            $this->courseRegRepository->deleteWhere(['student_id' => $id]);
            return true;
        }
        return true;
    }

    public function deleteMany($arr_ids)
    {
        if (!empty($arr_ids)) {
            foreach ($arr_ids as $id) {
                return $this->studentRepository->delete($id);
            }
        }
    }

    public function findAllEmails()
    {
        return $this->studentRepository->get()->pluck('email')->toArray();
    }

    public function findEmailsByIds($arr_ids)
    {
        return $this->studentRepository->findWhereIn('id', $arr_ids)->pluck('email')->toArray();
    }

    public function restore($id)
    {
        return $this->studentRepository->restore($id);
    }
}
