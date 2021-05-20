<div class="sidebar" data="green">
    <div class="sidebar-wrapper" style="background-color: #333232">
        <div class="logo">
            <a href="#" class="simple-text logo-normal" style="text-align:center;">
                <img src="{{ asset('img/logoAgua.png')}}" alt="Logo" class="img-fluid">
            </a>
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Início</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#register" aria-expanded="false" class="collapsed">
                    <i class="tim-icons icon-pencil"></i>
                    <span class="nav-link-text">Cadastros</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="register" style="">
                    <ul class="nav pl-4">
                        <li>
                            <a data-toggle="collapse" href="#person" aria-expanded="false" class="collapsed">
                                <i class="fas fa-users"></i>
                                <span class="nav-link-text">Pessoas</span>
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="person" style="">
                                <ul class="nav pl-4">
                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            <i class="fas fa-user-check"></i>
                                            <p>Usuários</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#general" aria-expanded="false" class="collapsed">
                                <i class="fas fa-bars"></i>
                                <span class="nav-link-text">Gerais</span>
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="general" style="">
                                <ul class="nav pl-4">
                                    <li>
                                        <a href="{{ route('cities.index') }}">
                                            <i class="fas fa-city"></i>
                                            <p>Cidades</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('states.index') }}">
                                            <i class="fas fa-layer-group"></i>
                                            <p>Estados</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            
        </ul>
    </div>
</div>
