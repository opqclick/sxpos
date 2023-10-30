<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Calendar;
use App\Models\Utility;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class CalendarController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Calendar Event')) {

            $events    = Calendar::where('created_by', '=', \Auth::user()->getCreatedBy())->get();

            $now = date('m');
            $current_month_event = Calendar::select('id','start', 'end', 'title', 'created_at', 'className')->whereRaw('MONTH(start)=' . $now)->get();

            $arrEvents = [];
            foreach ($events as $event) {

                $arr['id']    = $event['id'];
                $arr['title'] = $event['title'];
                $arr['start'] = $event['start'];
                $arr['end']   = $event['end'];
                $arr['className'] = $event['className'];

                
                $arr['url']             = route('calendars.edit', $event['id']);

                $arrEvents[] = $arr;
               
            }
            // $arrEvents = str_replace('"[', '[', str_replace(']"', ']', json_encode($arrEvents)));
            $arrEvents =  json_encode($arrEvents);

            return view('calendars.index', compact('events', 'arrEvents', 'current_month_event'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()

    {
        if (Auth::user()->can('Manage Calendar Event')) {

            return view('calendars.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    
        // if (Auth::user()->can('Create Calendar Event')) {
        //     $calendar             = new Calendar();
        //     $calendar->title      = $request->title;
        //     $calendar->start      = date('Y-m-d', strtotime($request->start));
        //     $calendar->end        = date('Y-m-d', strtotime($request->end));
        //     $calendar->allDay     = filter_var($request->allDay, FILTER_VALIDATE_BOOLEAN);
        //     $calendar->className  = $request->className;
        //     $calendar->created_by = Auth::user()->getCreatedBy();
        //     $calendar->save();

        //     return response()->json(
        //         [
        //             'code' => 200,
        //             'success' => __('Calendar event added successfully!'),
        //             'last_id' => $calendar->id,
        //         ]
        //     );
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }   


        {
            // dd($request->all());
            if (Auth::user()->can('Create Calendar Event')) {
                if($request->get('synchronize_type')  == 'google_calender')
                {
                    $type ='event';
                    // $request1=new Calendar();
                    // $request1->title=$request->title;
                    // $request1->start_date=$request->start_date;
                    // $request1->end_date=$request->end_date;
                
                    Utility::addCalendarData($request , $type);
                   
                
                
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'title' => 'required',
                        'start' => 'required',
                        'end' => 'required|after_or_equal:start',
                        // 'end_date' => 'required|after_or_equal:start_date',
                        'className' => 'required',
                    ]
                );
                if($validator->fails()) {
                    $messages = $validator->getMessageBag();
    
                    return redirect()->back()->with('error', $messages->first());
                }
                $event                = new Calendar();
                $event->title         = $request->title;
                $event->start         = $request->start;
                $event->end           = $request->end;
                $event->className     = $request->className;
                $event->description   = $request->description;
                $event->created_by    = \Auth::user()->getCreatedBy();
    
                $event->save();
            }
                else
                {
                    $validator = \Validator::make(
                        $request->all(),
                        [
                            'title' => 'required',
                            'start' => 'required',
                            'end' => 'required|after_or_equal:start',
                            // 'end_date' => 'required|after_or_equal:start_date',
                            'className' => 'required',
                        ]
                    );
                    if($validator->fails()) {
                        $messages = $validator->getMessageBag();
        
                        return redirect()->back()->with('error', $messages->first());
                    }
                    $event                = new Calendar();
                    $event->title         = $request->title;
                    $event->start         = $request->start;
                    $event->end           = $request->end;
                    $event->className     = $request->className;
                    $event->description   = $request->description;
                    $event->created_by    = \Auth::user()->getCreatedBy();
        
                    $event->save();
                }
    
            
                return redirect()->route('calendars.index')->with('success', __('Event successfully created.'));
             } 
            //  else {
            //     return redirect()->back()->with('error', __('Permission denied.'));
            // }
        }

    public function show($id)
    {
        $events    = Calendar::where('created_by', '=', \Auth::user()->getCreatedBy())->get();
    
        $now = date('m');
        $current_month_event = Calendar::select('id','start', 'end', 'title', 'created_at', 'className','description')->where('id',$id)->first();   
           
       

        return view('calendars.show',compact('current_month_event'));
    }

    public function edit($event)
    {

        $event = Calendar::find($event);


        return view('calendars.edit', compact('event'));
    }

    public function update(Request $request, Calendar $calendar)
    {
        if (Auth::user()->can('Edit Calendar Event')) {
            if ($calendar->created_by == \Auth::user()->getCreatedBy()) {
                
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'title' => 'required',
                        'start' => 'required',
                        'end' => 'required|after_or_equal:start', 
                        'className' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $calendar->title       = $request->title;
                $calendar->start       = $request->start;
                $calendar->end         = $request->end;
                $calendar->className   = $request->className;
                $calendar->description = $request->description;
                $calendar->save();
              


                return redirect()->back()->with('success', __('Event successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Calendar $calendar)
    {
        $calendar->delete();

        return redirect()->back()->with('success', __('Event successfully deleted.'));
    }

    public function get_event_data(Request $request)
    {
        $arrayJson = [];
        if($request->get('calender_type') == 'goggle_calender')
        {

            $type ='event';
            $arrayJson =  Utility::getCalendarData($type);
            

        }
        else
        {
            $data =Calendar::get();


            foreach($data as $val)
            {

                $end_date=date_create($val->end);
                date_add($end_date,date_interval_create_from_date_string("1 days"));
                $arrayJson[] = [
                    "id"=> $val->id,
                    "title" => $val->title,
                    "start" => $val->start,
                    "end" => date_format($end_date,"Y-m-d H:i:s"),
                    "url" => route('calendars.edit', $val['id']),
                    "className" => $val->className,
                 //  "textColor" => '#FFF',
                    "allDay" => true,
                ];
            }
        }

        return $arrayJson;
    }
}
