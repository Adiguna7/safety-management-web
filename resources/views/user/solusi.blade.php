@extends('layouts.userdashboard')

@section('header')
Alternatif Solusi
@endsection

@section('content')
    <div class="row">       
        @if($first_lowest !== null && isset($first_lowest))            
        <div class="col-lg-6">
            <div class="card shadow mb-4">            
                <div class="card-body">                    
                    <h5 class="card-title font-weight-bold">Dimensi {{ $first_lowest[0]->dimensi }}</h5>                                                                                                           
                    <form action="/survey/solusi/save" method="post" class="mt-5">                                                                                    
                    @csrf
                    @foreach ($first_lowest as $first)
                        <input type="hidden" name="solution_id[]" value="{{ $first->id }}">                    
                        <div class="form-check">
                            <input type="hidden" name="solutions{{ $first->id }}" value="0">
                            {{-- {{ $solanswer_assoc['solanswer'.$first->id] }} --}}
                            <input class="form-check-input" type="checkbox" name="solutions{{ $first->id }}" value="1" id="solution{{ $first->id }}"  @if(isset($solanswer_assoc['solanswer'.$first->id]) && $solanswer_assoc['solanswer'.$first->id] === 1) checked @endif>
                            <label class="form-check-label" for="solution{{ $first->id }}">
                                {{ $first->solution }}
                            </label>
                        </div>                                            
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>                       
        @elseif($second_lowest !== NULL && isset($second_lowest))            
        <div class="col-lg-6">
            <div class="card shadow mb-4">            
                <div class="card-body">                    
                    <h5 class="card-title font-weight-bold">Dimensi {{ $second_lowest[0]->dimensi }}</h5>                                                                                                           
                    <form action="/survey/solusi/save" method="post" class="mt-5">                                                                                    
                    @csrf
                    @foreach ($second_lowest as $second)  
                        <input type="hidden" name="solution_id[]" value="{{ $second->id }}">                                      
                        <div class="form-check">
                            <input type="hidden" name="solutions{{ $second->id }}" value="0">
                            <input class="form-check-input" type="checkbox" name="solutions{{ $second->id }}" value="1" id="solution{{ $second->id }}" @if(isset($solanswer_assoc) && $solanswer_assoc['solanswer'.$second->id] === 1) checked @endif>
                            <label class="form-check-label" for="solution{{ $second->id }}">
                                {{ $second->solution }}
                            </label>
                        </div>                                            
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection