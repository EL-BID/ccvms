<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="text-left">Status</th>
            <th class="text-left">Serie</th>
            <th class="text-left">Tipo Contenedor</th>
            <th class="text-left">Modelo</th>
            <th class="text-left">Capacidad</th>
            <th class="text-left">CLUE</th>
            @role('root|red-frio')<th class="text-left"> </th>@endrole
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key=>$item)
            <tr id="{{ $item->id }}" data-id="{{ $item->id }}" data-nombre="{{ $item->tipoContenedor->nombre }} con no. de serie: {{ $item->serie }} de la unidad {{ $item->clue->clues }}"  data-toggle="tooltip" data-placement="top" data-original-title="{{$item->usuario_id}}">
                <td class="text-center"><button type="button" class="btn btn-round" style="background-color:{{ $item->estatus->color }}; padding:8px 10px;"  data-toggle="tooltip" data-placement="right" data-original-title="{{$item->estatus->descripcion}}">  <i class="fa {{ $item->estatus->icono }}" style="color:white; font-size:x-large;"></i>  </button></td>
                <td class="text-left">{{ $item->serie }}</td>
                <td class="text-left">{{ $item->tipoContenedor->nombre }}</td>
                <td class="text-left">{{ $item->modelo->nombre }} / {{ $item->modelo->marca->nombre }}</td>
                <td class="text-left"> {{$item->capacidad}}
                    @if($item->unidades_medidas_id==4) Litros @endif
                    @if($item->unidades_medidas_id==39) Pies @endif
                </td>
                <td class="text-left">{{ $item->clue->clues }} - {{ $item->clue->nombre }}</td>                
                @role('root|red-frio')<td class="text-center col-md-1">                   
                    <a class="btn btn-primary" href="{{ url(Route::getCurrentRoute()->getPath().'/'.$item->id.'/edit') }}" class="button"> <i class="fa fa-refresh"></i> </a>
                    <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="fa fa-trash"></i></button>
                </td>@endrole
            </tr>
        @endforeach
    </tbody>
</table>

