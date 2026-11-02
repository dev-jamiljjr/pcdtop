<x-app-layout>
    <div class="container py-5">
        {{-- Imagem Centralizada no Topo --}}
        <div class="text-center mb-5">
            <img src="{{ asset('images/pcdtop-quem-somos.png') }}" class="img-fluid" alt="PCD TOP Imagem" style="max-width: 600px;">
        </div>

        {{-- SEÇÃO DE NOTÍCIAS --}}
        <hr class="my-5">
        <h2 class="text-center h3 fw-bold mb-4" style="color: var(--pcdtop-blue);">Notícias e Informações do Mundo do Trabalho</h2>

        <div class="row justify-content-center">
            {{-- Fonte 1: Pessoas com Deficiência --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold" style="color: var(--pcdtop-dark-blue);">Pessoas com Deficiência — Notícias</h5>
                        <p class="card-text text-muted flex-grow-1">Notícias e artigos sobre inclusão, direitos e o universo das pessoas com deficiência no mercado de trabalho.</p>
                        <a href="https://pessoascomdeficiencia.com.br/noticias" target="_blank" class="btn btn-primary mt-3" style="background-color: var(--pcdtop-blue); border-color: var(--pcdtop-blue);">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Acessar Fonte
                        </a>
                    </div>
                </div>
            </div>

            {{-- Fonte 2: Você RH — Pessoas com Deficiência --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold" style="color: var(--pcdtop-dark-blue);">Você RH — Pessoas com Deficiência</h5>
                        <p class="card-text text-muted flex-grow-1">Conteúdo especializado da Você RH sobre tendências, desafios e oportunidades para profissionais com deficiência.</p>
                        <a href="https://vocerh.abril.com.br/noticias-sobre/pessoas-com-deficiencia/" target="_blank" class="btn btn-primary mt-3" style="background-color: var(--pcdtop-blue); border-color: var(--pcdtop-blue);">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Acessar Fonte
                        </a>
                    </div>
                </div>
            </div>

            {{-- Fonte 3: Diário PCD — Trabalho e Empregabilidade --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold" style="color: var(--pcdtop-dark-blue);">Diário PCD — Trabalho e Empregabilidade</h5>
                        <p class="card-text text-muted flex-grow-1">Notícias diárias e informações relevantes sobre empregabilidade e inclusão para pessoas com deficiência.</p>
                        <a href="https://diariopcd.com.br/category/trabalho-empregabilidade/" target="_blank" class="btn btn-primary mt-3" style="background-color: var(--pcdtop-blue); border-color: var(--pcdtop-blue);">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Acessar Fonte
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- NOVA SEÇÃO INFORMATIVA SOBRE O PSE --}}
        <hr class="my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                {{-- Imagem de cabeçalho do PSE --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('images/pse_cabecalho.png') }}" class="img-fluid" alt="Cabeçalho do Programa Ser Eficiente">
                </div>

                {{-- Texto sobre o PSE --}}
                <div class="text-justify">
                    <p>O Programa Ser Eficiente (PSE) é um serviço do Centro Espírita Beneficente "30 de Julho", que tem como objetivo preparar, capacitar e acompanhar jovens com deficiência intelectual para a inserção e permanência no mundo do trabalho. Trata-se de um serviço integrado à Política Pública de Assistência Social, reconhecido nacionalmente pela sua excelência, tendo sido premiado pelo Fundo Itaú de Excelência Social (FIES) nos anos de 2009 e 2012.</p>
                    <p>Em 2014, em parceria com a Universidade Federal de São Paulo (UNIFESP), o PSE foi protagonista na criação do Fórum sobre a Empregabilidade da Pessoa com Deficiência (FEPEC), em Santos. O fórum tem como objetivo promover o diálogo entre famílias, instituições e a sociedade civil, fomentando ações colaborativas e defendendo políticas públicas que assegurem o direito à inclusão das pessoas com deficiência no mercado de trabalho.</p>
                    <p>O público atendido pelo Programa são pessoas com deficiência intelectual, com idades entre 16 e 40 anos, em situação de exclusão do mercado de trabalho formal e/ou informal.</p>
                    <p>A proposta do PSE é promover o desenvolvimento integral desses jovens, incentivando a aquisição de hábitos, habilidades e atitudes fundamentais para a autonomia e participação ativa na sociedade e no ambiente profissional.</p>
                    <h4 class="h5 mt-4 mb-3">Ações desenvolvidas pelo Programa:</h4>
                    <ul class="list-unstyled ps-3">
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Oficina de Construção da Postura Profissional (CPP);</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Curso de Preparação Profissional, em parceria com o SENAI;</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Atendimento, orientação e acompanhamento familiar;</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Grupo de preparação para atividades instrumentais da vida diária;</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Atendimento grupal com foco no conhecimento de direitos e protagonismo;</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Análise e adequação de cargos e postos de trabalho;</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Acompanhamento das pessoas inseridas no mercado de trabalho;</li>
                        <li class="mb-2"><i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; vertical-align: middle; color: var(--pcdtop-blue);"></i>Promoção da diversidade e inclusão nas empresas, na Rede Socioassistencial e na sociedade em geral.</li>
                    </ul>
                    <p class="mt-4">O Programa Ser Eficiente transforma vidas ao abrir portas, romper barreiras e construir caminhos reais de inclusão, dando voz, vez e dignidade a quem tem muito a contribuir com o mundo.</p>
                </div>
            </div>
        </div>

        {{-- SEÇÃO DE VÍDEOS DO PSE --}}
        <hr class="my-5">
        <div class="text-center">
            <h2 class="h3 fw-bold mb-4" style="color: var(--pcdtop-blue);">Conheça as Atividades, Ações e Depoimentos dos Jovens do Programa Ser Eficiente</h2>
        </div>

        <div class="row mt-4 justify-content-center">
            @php
                $videoIds = [
                    '0nO5K133JHs', 'zGgAlXmhEv8', '60wx5npVCV8', 'rKs606x3QVo',
                    'mMvo6k5S53w', 'bGdI9SX-oEc', '5STHsby3b-E', 'qG47Gb3ibM4', 'Jcw8iX4u8f0'
                ];
            @endphp

            @foreach ($videoIds as $videoId)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="ratio ratio-16x9 shadow-sm">
                        <iframe
                            src="https://www.youtube.com/embed/{{ $videoId }}"
                            title="Vídeo do YouTube sobre o Programa Ser Eficiente"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- NOVA SEÇÃO: CONHEÇA O CENTRO ESPÍRITA BENEFICENTE "30 DE JULHO" --}}
        <hr class="my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center h3 fw-bold mb-4" style="color: var(--pcdtop-blue);">Conheça o Centro Espírita Beneficente "30 de Julho"</h2>
                <p class="text-justify">Fundado em 30 de Julho de 1947, o Centro Espírita Beneficente "30 de Julho" (CEB 30 de Julho), é uma instituição filantrópica, que ao longo dos anos cresceu e evoluiu, investindo no capital humano, adequando-se a novos conceitos e tecnologias, solidificando-se no objetivo da busca em defesas e garantias do direito na sociedade para crianças, jovens e adultos PCD (Pessoa com Deficiência) intelectual e/ou déficit de aprendizagem, direcionando gratuitamente nossas ações nas áreas da educação e assistência social, através de 02 serviços: a Escola de Educação Especial "30 de Julho" e o Programa Ser Eficiente. Também dá apoio sócio familiar direcionado à família dos atendidos com base na Política Nacional de Assistência Social.</p>

                <h4 class="h5 mt-4 mb-3" style="color: var(--pcdtop-dark-blue);">Links da Instituição:</h4>
                <ul class="list-unstyled ps-3">
                    <li class="mb-2"><i class="bi bi-globe me-2" style="font-size: 0.9rem; vertical-align: middle; color: var(--pcdtop-blue);"></i><strong>Site:</strong> <a href="http://30dejulho.com.br" target="_blank" class="text-primary">30dejulho.com.br</a></li>
                    <li class="mb-2"><i class="bi bi-facebook me-2" style="font-size: 0.9rem; vertical-align: middle; color: var(--pcdtop-blue);"></i><strong>Facebook:</strong> <a href="https://facebook.com/30dejulho" target="_blank" class="text-primary">facebook.com/30dejulho</a></li>
                    <li class="mb-2"><i class="bi bi-instagram me-2" style="font-size: 0.9rem; vertical-align: middle; color: var(--pcdtop-blue);"></i><strong>Instagram:</strong> <a href="https://instagram.com/ceb30dejulho" target="_blank" class="text-primary">instagram.com/ceb30dejulho</a></li>
                    <li class="mb-2"><i class="bi bi-youtube me-2" style="font-size: 0.9rem; vertical-align: middle; color: var(--pcdtop-blue);"></i><strong>Youtube:</strong> <a href="https://youtube.com/ceb30dejulho" target="_blank" class="text-primary">youtube.com/ceb30dejulho</a></li>
                </ul>
            </div>
        </div>

    </div>
</x-app-layout>
