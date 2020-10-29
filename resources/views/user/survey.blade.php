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
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">            
            <form action="/survey/submit" method="post">
                @csrf
                @foreach ($survey_question as $question)                                
                <div class="form-group mt-5">
                    <div>Number {{ $question->no_question }} :</div>
                    <div class="mt-2">{{ $question->text_question }}</div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="question{{$question->no_question}}" id="exampleRadios1" value="1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                        {{ $question->option_1 }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question->no_question}}" id="exampleRadios2" value="2">
                        <label class="form-check-label" for="exampleRadios2">                        
                        {{ $question->option_2 }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question->no_question}}" id="exampleRadios3" value="3">
                        <label class="form-check-label" for="exampleRadios3">                        
                        {{ $question->option_3 }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question->no_question}}" id="exampleRadios4" value="4">
                        <label class="form-check-label" for="exampleRadios4">                        
                        {{ $question->option_4 }}
                        </label>
                    </div>                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{$question->no_question}}" id="exampleRadios5" value="5">
                        <label class="form-check-label" for="exampleRadios5">                        
                        {{ $question->option_5 }}
                        </label>
                    </div> 
                    <input type="hidden" name="questionid{{ $question->no_question }}" value="{{ $question->id }}">                                                   
                </div>
                @endforeach                
                <div class="col-lg-4">                    
                    <div class="form-group">
                        <label for="institutioncode">Institution Code</label>
                        <input type="text" name="institution_code" class="form-control" id="institutioncode" aria-describedby="institutioncode" placeholder="Institution Code ...">                    
                        <small>* Get Code From Admin</small>
                    </div>
                </div>                
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>    
@endsection