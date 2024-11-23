# Projeto Lista de tarefas

Este é um projeto de lista de tarefas, desenvolvido na linguagem PHP,
utilizando o framework web Laravel, e o framework Livewire, para a criação de
componentes interativos que interagem com o backend sem a necessidade de atualização de página.

O projeto foi desenvolvido buscando ser de fácil interação para o usuário, 
com ícones e práticas de design (UI/UX) que facilitam o uso da aplicação.

Ao mesmo tempo, também foi feito pensando em ter um código limpo, com boas práticas
de programação, organização de código e uma boa documentação.

## Acessar aplicação

Esse projeto teve seu *deploy* feito na plataforma Railway, e pode ser acessado **[neste link](https://lista-tarefas-production-c064.up.railway.app/)**

Foi desenvolvida uma segunda versão com uma modificação adicional para esse projeto, com um container limitado com rolagem interna, de forma que o usuário não precise descer a tela da lista toda caso queira adicionar uma nova tarefa, essa versão pode ser acessada [aqui](https://lista-tarefas-copy-production.up.railway.app).

## Arquivos importantes

Os arquivos principais deste código são:

- [Tarefa.php (Model Tarefa)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Models/Tarefa.php).
- [ListaTarefas.php (Classe do componente)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php).
- [lista.blade.php (Página inicial)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/lista.blade.php).
- [lista-tarefas.blade.php (View do componente)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/lista-tarefas.blade.php).
- [adicionar-tarefa.blade.php (Incluído pela view lista-tarefas)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/adicionar-tarefa.blade.php).
- [card-tarefa.blade.php (Incluído pela view lista-tarefas)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php).

Outros arquivos envolvidos:

- [create_tarefas_table.php (Migration que gera a tabela)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/database/migrations/2024_11_17_154030_create_tarefas_table.php)
- [web.php (Arquivo de rotas)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/routes/web.php)
- [styles.css (Estilos)](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/public/css/styles.css)

## Funcionamento de um componente

Os mecanismos principais das tarefas ocorrem por meio do compontente ListaTarefas,
que consiste de 2 arquivos:

### lista-tarefas.blade.php

É a view blade, que contém a interface HTML do componente ListaTarefas, e os elementos
necessarios para realizar ações do componente, como criar, editar, excluir e reordenar tarefas.

### ListaTarefas.php

É o arquivo que gerencia a lógica do componente, recebendo dados e realizando métodos. O componente permite a atualização em tempo real, enviando as atualizações para o front-end sem a necessidade de atualizar a página, de forma dinâmica e eficiente, tanto para o código como a experiência do usuário.

Esses arquivos se comunicam por meio dos métodos e atributos, que são ligados por meio
de atributos HTML wire nas páginas.

#### Exemplo:

Um input no HTML pode ser ligado a um atributo "nome" do componente da seguinte forma:

##### lista-tarefas.blade.php (View)
> \<input type="text" wire:model="nome">

E um botão, ligado a um método:

> \<button wire="pesquisar">Pesquisar nome\</button>

No backend, a lógica ficaria assim:

##### ListaTarefas.php
> class ListaNomes extends component{
>    
> public $nome; // Ligado ao input com *wire:model="nome"*
> 
> public function pesquisar(){ // Chamado pelo botão com *wire="pesquisar"*
>
>   $nomePesquisado = $this->nome;
>
>   $usuarios[] = User::latest()->where('nome','like',"%{$nomePesquisado}%");
>
>    }
> 
> }
>

## Processo seletivo FATTO

Esse projeto foi desenvolvido como um teste para o processo seletivo de estágio da FATTO Consultorias e Software. Seguem os tópicos solicitados no e-mail do processo seletivo, e como cada um foi cumprido:

### Base de dados - Tabela: Tarefas

A tabela foi gerada em uma das migrations do Laravel, que foi executada na implantação do projeto com o comando **php artisan migrate**. A tabela 'tarefas' foi gerada no banco de dados com a migration, tendo as colunas:

- id (Identificador da tarefa)
- nome (Nome da tarefa)
- custo (Custo (R$))
- data_limite (Data limite)
- ordem_apresentacao (Ordem de apresentação)

Também existem colunas padrão de data de criação e última data de edição

- created_at
- updated_at

### Lista de tarefas

A página principal do sistema, é roteada no arquivo de rotas: [web.php](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/routes/web.php).

As tarefas são apresentadas uma abaixo da outra em forma de cards, ordenadas pela coluna 'ordem_apresentação'. A ordenação é feita no método **[render](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L284)**, no componente ListaTarefas.php.

A tarefa com custo maior que R$ 1.000,00 tem o fundo amarelo, destacando-se das demais. Esse mecanismo é feito com o blade (template engine), no arquivo **[card-tarefa.blade.php](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php)**, na linha 2.

Os botões com as funções de "Editar" e "Excluir" estão no arquivo **[card-tarefa.blade.php](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php#L54)**.

Ao final da lista, há uma seção para "Incluir" um novo registro, localizada no arquivo **[adicionar-tarefa.blade.php](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/adicionar-tarefa.blade.php)**.

### Excluir

**[Na view](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php#L59)**, o usuário pode excluir uma tarefa clicando no *botão* com ícone de lixeira, ao lado direito da tarefa, acionando o método *delete* **[no componente](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L145)**, que após a confirmação do usuário, busca a tarefa no banco de dados via seu ID, e remove a mesma.

### Editar

**[Na view](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php#L55)**, o usuário pode editar uma tarefa clicando no *botão* com ícone de lápis, ao lado direito da tarefa, acionando o método *edit* **[no componente](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L77)**, que habilita a tarefa selecionada para edição, transformando os valores que antes eram textos, em inputs, para que o usuário modifique cada valor na própria tarefa.

Assim que o usuário terminar de modificar o que deseja basta clicar no botão *atualizar* ou *cancelar*.

O botão *atualizar* aciona o método **[update](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L99)**,
que pega os valores inseridos nos campos, e atualiza a tarefa no banco de dados.

O botão *cancelar* aciona o método **[cancelEdit](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L126)**, que para a edição, e deixa o card da tarefa da mesma forma que antes.

### Incluir

**[Na view](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/adicionar-tarefa.blade.php)**, o usuário pode incluir uma tarefa preenchendo o formulário de nova tarefa, e após isso clicar no botão *[incluir tarefa](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/adicionar-tarefa.blade.php#L28)*, acionando o método *create* **[no componente](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L44)**, criando um novo objeto Tarefa, e salvando o mesmo no banco de dados.

### Reordenação de tarefas

Foram implementadas as duas formas de reordenação sugeridas.

1) O usuário pode arrastar uma tarefa clicando no **[ícone](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php#L34)** no canto superior direito do card, e arrastar a tarefa para onde desejar. Com o uso do plugin Livewire SortableJs, uma tarefa pode ser arrastada, e um array com a ordem atualizada dos componentes é enviado para o método **[updateOrder](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L216)**, que reorganiza as tarefas com base no array fornecido.

2) O usuário pode clicar nos **[ícones](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php#L38)** no canto direito do card, para movimentar a tarefa para baixo ou para cima. Se a tarefa for a primeira da lista, o botão de mover para cima terá uma cor mais clara e não funcionará, e o mesmo se aplica ao botão de baixo, se a tarefa for a última da lista. Os botões tem um método para cada um no componente, sendo eles **"[cardUp](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L163)"** e **"[cardDown](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/app/Livewire/ListaTarefas.php#L190)"**.

## Requisitos não funcionais

## Validação

Todos os atributos preenchidos em campos de formulário são validados antes de serem processados e utilizados em algum método, tanto nos campos de criação quanto edição de tarefas.

### Nome

- É obrigatório
- Deve ser único
- Deve ter no mínimo 2 letras, e no máximo 50

### Custo

- É obrigatório
- Deve ser um valor numérico
- Deve ser maior ou igual a 0

### Data Limite

- É obrigatório
- Deve ser uma data
- Deve ser uma data posterior à data em que o usuário estiver criando o sistema


**Caso algum dos requisitos de um dos atributos não for válido, a tarefa não será criada/edita e um aviso explicando o valor inválido aparecerá abaixo de cada campo necessário**

## Usabilidade

As cores, tamanhos de fontes e contrastes definidos foram feitos de forma que fizesse o uso da aplicação ser intuitivo e fácil.

- Ao clicar em editar um arquivo, os campos de edição aparecem com o mesmo **tamanho de texto** e **posição** de onde cada atributo da tarefa estava, de forma que o usuário não tenha o trabalho de pensar onde procurar os campos de edição.

- Ao passar o mouse por cima de cada tarefa, um texto menos destacado aparecerá ao lado da data, esse texto mostra quanto tempo falta para a data limite de cada tarefa chegar.
Exemplo, se hoje é dia 23/11, e a data limite da tarefa é 30/11, ao lado da data limite aparecerá a mensagem "em 6 dias", afim de mostrar de forma mais compreensível o tempo restante para o cumprimento da tarefa.

- O elemento HTML **[card-tarefa](https://github.com/arthurssrichard/lista-tarefas/tree/no-docker/resources/views/livewire/includes/card-tarefa.blade.php)** foi adaptado para preencher a tela, caso o usuário esteja acessando via dispositivo móvel.

- As datas são convertidas para o formato dd/mm/yyyy, que é o padrão no Brasil.

- Foi desenvolvida uma segunda versão do projeto, com um container limitado e rolagem interna, para que o usuário não precise rolar toda a tela para adicionar uma nova tarefa, essa versão pode ser acessada [aqui](https://lista-tarefas-copy-production.up.railway.app).