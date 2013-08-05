<?php 
class Tour extends Eloquent {
    protected $table = 'tours';
    protected $guarded = array() ; 
    
    static public function create(array $attr)
    {
        $tour = new Tour ; 
        $tour->fill($attr) ; 
        $duplicate_check = $tour->where('register_id','=',(int)$attr['register_id'])->where('user_id','=',(int)$attr['user_id'])->count();
        if($duplicate_check){
            throw new Exception('msg') ; 
        }

        $register = new Register;
        $pre_register = $register->find($attr['register_id']);

        if($pre_register->limit_people <= $pre_register->register_people){
            throw new Exception('msg') ; 
        }


        $data['register_people'] = (int)$pre_register->register_people + 1;
        $pre_register->update($data);
        $tour->save() ; 

        return $tour ; 
    }

    public function hit_count($id)
    {
        $register = new Register;
        $pre_register = $register->find($id);

        $data['hit'] = (int)$pre_register->hit + 1;
        $pre_register->update($data);
    }
}
