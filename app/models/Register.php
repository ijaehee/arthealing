<?php 
class Register extends Eloquent {
    protected $table = 'registers';
    protected $guarded = array() ; 
    
    static public function create(array $attr){
        $reg = new Register ; 
        $reg->fill($attr) ; 

        if($attr['program_id'] == null || $attr['program_id'] == ''){
            throw new Exception('msg') ; 
        }
        $reg->save() ; 

        return $reg; 
    }

    public function getList($search_param=null,$page=1,$list_count=10){
        $model = Register::select('registers.*','programs.main_src','programs.name')->join('programs', 'programs.id', '=', 'registers.program_id');

        $result = array();
        if($search_param != null){
            $result = $model->where($search_param['key'],$search_param['keyword'])->orderBy('registers.id','desc')->paginate($list_count);
        }else{
            $result = $model->orderBy('registers.id','desc')->paginate($list_count);
        } 
        
        return $result;
    }
}
