<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            // 'user'=> (isset($this->user))?array('id'=>$this->user->id,'name'=>$this->user->name):'',
            // 'writer'=> (isset($this->writer))?array('id'=>$this->writer->id,'name'=>$this->writer->name):'',
            'user'=> (isset($this->user))?$this->user->name:'',
            'writer'=> (isset($this->writer))?$this->writer->name:'',
            'title'=> $this->title,
            'text'=> $this->text,
            'type'=> (string)$this->type,
            // 'branch'=> (isset($this->branch))?array('id'=>$this->branch->id,'name'=>$this->branch->name):'',
            'branch'=> (isset($this->branch))?$this->branch->name:'',
            'created_at'=> date_format($this->created_at,'Y-m-d H:i:s'),
            'updated_at'=> date_format($this->updated_at,'Y-m-d H:i:s'),
        ];
        // return parent::toArray($request);
    }
}
