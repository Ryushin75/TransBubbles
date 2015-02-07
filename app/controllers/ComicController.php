<?php

class ComicController extends BaseController {
	
    public function addForm() {
        return $this->form(new Comic(), true);
    }
    
    public function updateForm($id) {
        $c = Comic::find($id);
        if ($c == null) {
            return Redirect::route('comic.add');
        }
        
        return $this->form($c, false);
    }
    
    private function form($comic, $isAdd) {
        return View::make('comic.update', [
            'fonts' => Font::all()->lists('name', 'id'),
            'comic' => $comic,
            'isAdd' => $isAdd,
        ]);
    }

    public function add() {
        
        return $this->checkAndSave(new Comic(), function($c, $v) {
            
            if ($v->passes()) {
                return Redirect::route('comic.update', [$c->id])
                    ->withMessage(Lang::get('comic.added', [
                        'title' => $c->title,
                    ]));
            }
            return Redirect::route('comic.add')
                ->withInput()
                ->withErrors($v)
                ->withMessage(Lang::get('comic.errorMessage'));
        });
        
    }
    
    public function update($id) {
        
        return $this->checkAndSave(Comic::find($id), function($c, $v) {
            
            if ($v->passes()) {
                return Redirect::route('comic.update', [$c->id])
                    ->withMessage(Lang::get('comic.updated', [
                        'title' => $c->title,
                ]));
            }
        
            return Redirect::route('comic.update', [$c->id])
                ->withInput()
                ->withErrors($v)
                ->withMessage(Lang::get('comic.errorMessage'));

        });
    }
    
    private function checkAndSave($comic, $return) {
        
        $v = Validator::make(Input::all(), Comic::rules());
        
        if($v->passes()) {
            $comic->title = Input::get('title');
            $comic->author = Input::get('author');
            $comic->description = Input::get('description');
            $comic->authorApproval = Input::get('authorApproval');
            if (Input::hasFile('cover')) {
                Comic::dropFile($comic->cover);
                $comic->cover = Comic::uploadFile(Input::file('cover'));
            }
            $comic->font_id = Input::get('font_id');
            $comic->save();
        }
        
        return $return($comic, $v);
        
    }
    
    public function delete($id) {
        
        Comic::destroy($id);
        return Redirect::back();
        
    }

}
