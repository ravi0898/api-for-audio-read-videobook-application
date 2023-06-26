<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use Illuminate\Support\Facades\Crypt;

class ChapterController extends Controller
{
   
    public function index($bookid)
    {
        $id = Crypt::decrypt($bookid); 
        $chapters = Chapter::where('book_id', $id)->orderBy('chapter_no','ASC')->get();
        return view('admin.chapter.index',compact('chapters', 'id'));
    }

    
    public function create()
    {
        return view('admin.chapter.create');
    }

    
    public function store(Request $request)
    { 
        $validated = $request->validate([
            'chapter_no' => 'required',
            'chapter_name' => 'required',
            'content' => 'required',
        ]);

        if($request->file('document')){
            $image = $request->file('document');
            if($image->isValid()){
                if(!empty($request->input('document_old'))){
                    if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                        unlink(public_path('/').'/'.$request->input('document_old')); 
                    }
                }
                $extension = $image->getClientOriginalExtension();
                $fileName = rand(100,999999).time().'.'.$extension;
                $image_path = public_path('upload/book/audio');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/book/audio/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $data = array(
            "chapter_no"=>$request->input('chapter_no'),
            "chapter_name"=>$request->input('chapter_name'),
            "chapter_description"=>$request->input('content'),
            "audio_title"=>$request->input('audio_title'),
            "audio"=>$formInput['document'],
            "book_id"=>$request->input('bookid'),
        );
        
        $id = Chapter::create($data)->id;
        return redirect()->back()->with('success_add', 'Chapter Added Successfully');
    
    }

    
   
    
    public function destroy($id)
    {
        $delete = Chapter::findOrFail($id);
		$image1 = $delete->audio; 
		$image = "public/".$image1;
		if($delete->delete()){
			if(!empty($image)){
				if(file_exists($image)){
					unlink($image);
				}
			}
        }
        return redirect()->back()->with('success','Chapter Deleted Successfully');
    
    }
    
    
      public function edit($id)
    {
        $chid = Crypt::decrypt($id); 
        $chapter = Chapter::where('id', $chid)->first();
        return view('admin.chapter.edit', compact('chapter'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'chapter_no' => 'required',
            'chapter_name' => 'required',
            'content' => 'required',
        ]);

        if($request->file('document')){
            $image = $request->file('document');
            if($image->isValid()){
                if(!empty($request->input('document_old'))){
                    if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                        unlink(public_path('/').'/'.$request->input('document_old')); 
                    }
                }
                $extension = $image->getClientOriginalExtension();
                $fileName = rand(100,999999).time().'.'.$extension;
                $image_path = public_path('upload/book/audio');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/book/audio/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $data = array(
            "chapter_no"=>$request->input('chapter_no'),
            "chapter_name"=>$request->input('chapter_name'),
            "chapter_description"=>$request->input('content'),
            "audio_title"=>$request->input('audio_title'),
            "audio"=>$formInput['document'],
            
        );

        
            $chapterid = $request->input('chapterid');
            Chapter::where('id',$chapterid)->update($data);
           
            return redirect()->back()->with('success',"Chapter updated successfully!");
            
           
    }


   



}

