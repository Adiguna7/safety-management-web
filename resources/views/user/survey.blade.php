@extends('user.template')

@section('isiuser')
<div class="container" style="margin-top: 35px; margin-bottom: 75px">
    @if($message = Session::get('error'))
    <div class="row">        
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>        
    </div>    
    @elseif($message = Session::get('success'))
    <div class="row">        
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>        
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10 d-flex justify-content-center">            
            <form action="/survey/submit" method="post">
                @csrf                
                @foreach ($survey_question as $question)                                                                        
                <div class="form-group mt-5">
                    <div>Number: {{ $loop->index + 1 }}</div>
                    <div class="mt-2">{{ $question["text_question"] }}</div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="question{{$question["no_question"]}}" id="exampleRadios1" value="{{ $options[0] }}" checked>
                        <label class="form-check-label" for="exampleRadios1">
                        {{ $question["option_".$options[0]] }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question["no_question"]}}" id="exampleRadios2" value="{{ $options[1] }}">
                        <label class="form-check-label" for="exampleRadios2">                        
                        {{ $question["option_".$options[1]] }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question["no_question"]}}" id="exampleRadios3" value="{{ $options[2] }}">
                        <label class="form-check-label" for="exampleRadios3">                        
                        {{ $question["option_".$options[2]] }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question["no_question"]}}" id="exampleRadios4" value="{{ $options[3] }}">
                        <label class="form-check-label" for="exampleRadios4">                        
                        {{ $question["option_".$options[3]] }}
                        </label>
                    </div>                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question["no_question"]}}" id="exampleRadios5" value="{{ $options[4] }}">
                        <label class="form-check-label" for="exampleRadios5">                        
                        {{ $question["option_".$options[4]] }}
                        </label>
                    </div> 
                    <input type="hidden" name="questionid{{ $question["no_question"] }}" value="{{ $question["id"] }}">                                                   
                </div>
                @endforeach                                               
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>    
@endsection