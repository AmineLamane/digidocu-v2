<!-- Name Field -->
<div class="form-group col-sm-6">
{!! Form::label('name', 'Nom:') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
{{--if in edit mode--}}
@if ($document)
    @if (auth()->user()->can('update document '.$document->id) && !auth()->user()->is_super_admin)
        @foreach($document->tags->pluck('id')->toArray() as $tagId)
            <input type="hidden" name="tags[]" value="{{$tagId}}">
        @endforeach
    @else
        <div class="form-group col-sm-6 ">
            <label for="tags[]">{{ucfirst(config('settings.tags_label_plural'))}}</label>
            <select class="form-control select2" id="tags"
                    name="tags[]"
                    >
                @foreach($tags as $tag)
                    @can('update', [$document, [$tag->id]]))
                        <option
                            value="{{$tag->id}}" {{(in_array($tag->id,old('tags', optional(optional(optional($document)->tags)->pluck('id'))->toArray() ?? [] )))?"selected":"" }}>{{$tag->name}}</option>
                    @endcan
                @endforeach
            </select>
        </div>
    @endif
@else
    <input type="hidden" name="tags[]" value="{{$gettag->id}}">
    <div class="form-group col-sm-6 {{ $errors->has("tags") ? 'has-error' :'' }}">
        <label for="tags">{{ucfirst(config('settings.tags_label_singular'))}}:</label>
        <select class="form-control select2" id="tags" name="tags[]" disabled>
            @foreach($tags as $tag)
                @canany (['create documents','create documents in tag '.$tag->id])
                    @if($tag->id == $gettag->id)
                    <option
                    value="{{$tag->id}}" selected>{{$tag->name}}</option>
                    @endif
                @endcanany
                
                @foreach($parents as $parent)
                @can('create documents in tag '.$parent)
                    @if($tag->id == $gettag->id)
                    <option
                    value="{{$tag->id}}" selected>{{$tag->name}}</option>
                    @endif
                @endcan
                @endforeach
            @endforeach
        </select>
        {!! $errors->first("tags",'<span class="help-block">:message</span>') !!}
    </div>
@endif
{!! Form::bsTextarea('description',null,['class'=>'form-control b-wysihtml5-editor']) !!}


{{--additional Attributes--}}
@foreach ($customFields as $customField)
    <div class="form-group col-sm-6 {{ $errors->has("custom_fields.$customField->name") ? 'has-error' :'' }}">
        {!! Form::label("custom_fields[$customField->name]", Str::title(str_replace('_',' ',$customField->name)).":") !!}
        {!! Form::text("custom_fields[$customField->name]", null, ['class' => 'form-control typeahead','data-source'=>json_encode($customField->suggestions),'autocomplete'=>is_array($customField->suggestions)?'off':'on']) !!}
        {!! $errors->first("custom_fields.$customField->name",'<span class="help-block">:message</span>') !!}
    </div>
@endforeach
{{--end additional attributes--}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
    {!! Form::submit('Sauvegarder et Uploader', ['class' => 'btn btn-primary','name'=>'savnup']) !!}
    @if($document)
    <a href="{!! route('documents.show',$document->id) !!}" class="btn btn-default">Annuler</a>
    @else
    <a href="{!! route('documents.index',['tags' => $gettag->id]) !!}" class="btn btn-default">Annuler</a>
    @endif
</div>
