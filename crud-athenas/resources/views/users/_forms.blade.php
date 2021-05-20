    <div class="row">
        <div class="col-md-4">
            {!!Form::text('nif', 'CPF')
            ->attrs(['class' => 'cpf_cnpj'])
            ->required()
            !!}
        </div>
        <div class="col-md-8">
            {!!Form::text('name', 'Nome')
            ->required()
            ->attrs(['maxlength' => 70])!!}
        </div>
        <div class="col-md-4">
            {!!Form::text('email', 'Email')->type('email')
            ->required()
            !!}
        </div>
        <div class="col-md-4">
            {!!Form::text('phone', 'Telefone')
            ->attrs(['class' => 'phone'])
            ->required()
            !!}
        </div>
        <div class="col-md-4">
            {!!Form::select('types', 'Categoria', ['' => 'Selecione...'] + \App\Person::types())
            ->required()
            !!}
        </div>

        <div class="col-md-8">
            {!!Form::text('address', 'Endereço')
            ->required()
            !!}
        </div>
        <div class="col-md-4">
            {!!Form::select('is_enabled', 'Ativo', [ 1 => 'Sim', 0 => 'Não'])
            ->value(isset($item) ? $item->is_enabled : 1)
            ->required()
            !!}
        </div>

        @if(!isset($item))
        <div class="col-md-4">
            {!!Form::text('password', 'Senha')->type('password')
            ->attrs(['minlength' => 8])
            ->required()
            !!}
        </div>
        <div class="col-md-4">
            {!!Form::text('password_confirmation', 'Confirmar Senha')->type('password')
            ->attrs(['minlength' => 8])
            ->required()
            !!}
        </div>
        @endif
        
    </div>
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-success float-right mt-4">Salvar</button>
        </div>
    </div>
