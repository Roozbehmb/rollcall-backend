//            $traffic_s=$_traffic->where('id',$request->user_id[1])
//                ->create(
//                    [
//                        'user_id'=>$request->get('user_id'),
//                        'enter_date'=>$request->get('enter_date'),
//                        'exit_date'=>$request->get('exit_date'),
//                        'enter_time'=>$request->get('enter_time'),
//                        'exit_time'=>$request->get('exit_time'),
//                        'id_day'=>$request->id_day[1]
//                    ]);



//            $co = 0;
//            $_days = 1;
//
//            for ($i = 1; $i < $count_days; $i++) {
//
//                if ($_days <= 12 && $ars_d <= 31) {
//                    $date = (new Jalalian($ars_y, $_days, $ars_d))->format('%A');
//                    $ars_d++;
//                    if ($date == "شنبه") {
//                        $co++;
//                    }
//
//                } else {
//                    $ars_d = 1;
//                    $_days = 1;
//                }
//            }
//            return $co;


public function create_traffic($create_t, $count, $data_at, $data_up)
{
$array_date_now_name_month = Jalalian::forge(now())->format('%B');
$array_date_now_month = Jalalian::forge(now())->format('%y');
$array_date_now_name_day = Jalalian::forge(now())->format('%A');


for ($i = 0; $i <= $count; $i++) {
$mult_traffic = new traffic();
$mult_traffic->enter_time = $create_t->enter_time;
$mult_traffic->exit_time = $create_t->enter_time;
$mult_traffic->absents_id = $create_t->enter_time;
$mult_traffic->time_day_absents = $create_t->enter_time;
$mult_traffic->user_id = $create_t->enter_time;


$mult_traffic->date = $data_at;
$mult_traffic->up_to_date = $data_up;
//            if($array_date_now_name_day == )
//            {
//                $traffic = Traffic::create($mult_traffic->all());
//
//            }

}
}


//    public function date_check($request_data)
//    {
//        $jdf = new Jdf();
//        $data_at = $jdf->tr_num($jdf->jdate('Y:m:d'));
//
//        $data_up = "1402:01:10";
//        $arr_date = [
//            'data_at' => explode(':', $data_at),
//            'data_up' => explode(':', $data_up)
//        ];
//
//
//        foreach ($arr_date as $key => $inter_T) {
//            $int_date['data_at']['year'] = (int)$arr_date['data_at'][0];
//            $int_date['data_at']['month'] = (int)$arr_date['data_at'][1];
//            $int_date['data_at']['day'] = (int)$arr_date['data_at'][2];
//
//            $int_date['data_up']['year'] = (int)$arr_date['data_up'][0];
//            $int_date['data_up']['month'] = (int)$arr_date['data_up'][1];
//            $int_date['data_up']['day'] = (int)$arr_date['data_up'][2];
//        }
//
//        if ($int_date['data_at']['year'] == $int_date['data_up']['year']) {
//            if ($int_date['data_at']['month'] > $int_date['data_up']['month']) {
//                if ($int_date['data_at']['day'] > $int_date['data_up']['day']) {
//                    $count = $int_date['data_at']['day'] - $int_date['data_up']['day'];
//                    return
//                        $this->create_traffic($request_data, $count, $data_at, $data_up);
//                }
//            }
//        } else {
//            return "message date year";
//        }
//
//        return $int_date;
//        $i = 0;
//        foreach ($arr_date as $key=>$data) {
//            $i++;
//            $int_at_date = (int)$data;
//
//
//            $int_up_date = (int)$data;
//            $data_C[$i] = $int;
//
//            if($data_C[$i] > )
//        }
//        return $data_C[1];


//        $date_at=$request_data->get('date');
//        $up_to_date=$request_data->get('up_to_date');
//        if ($up_to_date && $date_at)
//        {
//
//            $traffic = Traffic::create($request_data->all());
//            return $date_at->get('up_to_date');
//        }
//        foreach ($substrings as $key => $stt) {
//            $i++;
//            $int = (int)$stt;
//            $test[$i] = $int;
//        }
//        return array($date_at);

//    }
<!--$substrings = explode('-', $request->get('enter_date'));-->
<!--$ars_y = (int)$substrings[0];-->
<!--$ars_m = (int)$substrings[1];-->
<!--$ars_d = (int)$substrings[2];-->
<!---->
<!--$substrings = explode('-', $request->get('exit_date'));-->
<!--$ars_exit_time_y = (int)$substrings[0];-->
<!--$ars_exit_time_m = (int)$substrings[1];-->
<!--$ars_exit_time_d = (int)$substrings[2];-->
<!--$count_days = ($ars_exit_time_m * 30 + $ars_exit_time_d) - ($ars_m * 30 + $ars_d);-->
