@extends('layout.app', ["current" => "produtos" ])

@section('body')
	<div class="card border">
    <div class="card-body">
        <h5 class="card-title">Cadastro de produtos</h5>

        <table id="tabProdutos" class="table table-ordered table-hover">
            <thead>
                <tr>
                    <th>Código</th>
					<th>Nome</th>
					<th>Quantidade</th>
					<th>Preço</th>
					<th>Departamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-primary" role="button" onclick="novoProduto()">Novo produto</button>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="dlgProd">
	<div class="modal-dialog" role=document>
		<div class='modal-content'>
			<form class='form-horizontal' id='FormProduto'>
			<div class="modal-header">
				<h5 class="modal-tittle">Novo produto</h5>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id" class='form-control'>
				<div class="form-group">
					<label for="nomeProduto" class='control-label'>Nome do produto</label>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Nome do produto" id="nomeProduto" name="nomeProduto">
					</div>
				</div>
				<div class="form-group">
					<label for="precoProduto" class="control-label">Preço do produto</label>
					<div class="input-group">
						<input type="number" class="form-control" placeholder="Preço do produto" id="precoProduto" name="precoProduto">
					</div>
				</div>
				<div class="form-group">
					<label for="quantProduto" class='control-label'>Quantidade do produto</label>
					<div class="input-group">
						<input type="number" class="form-control" placeholder="Quantidade do produto" id="quantProduto" name="quantidadeProduto">
					</div>
				</div>
				<div class="form-group">
					<label for="catProduto" class='control-label'>Categoria do produto</label>
					<div class="input-group">
						<select  class="form-control" id="catProduto" name="categoriaProduto">
						</select>
					</div>
				</div>
			</div>
			<div>
				<button type="submit" class="btn-sm btn btn-primary">Salvar</button>
				<button type="submit" class="btn-sm btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
			</form>
	</div>
	</div>

</div>

@endsection


@section('javascript')
	<script type="text/javascript">
		$.ajaxSetup({
			headers: { 
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			}
		});

		function novoProduto() {
			$('#nomeProduto').val('')
			$('#precoProduto').val('')
			$('#quantProduto').val('')
			$('#catProduto').val('')
			$('#dlgProd').modal('show');
		}

		function carregarCategorias() {
			$.getJSON('/api/categorias', function(data){
				for(i=0; i < data.length; i++) {
					opcao = '<option value="' + data[i].id  + '">' + data[i].nome + '</option>';
					$('#catProduto').append(opcao)
				}
			});
		}

		function montarLinha(p) {
			var linha = "<tr>" + 
				"<td>" + p.id + "</td>" +
				"<td>" + p.nome + "</td>" +
				"<td>" + p.estoque + "</td>" +
				"<td>" + p.preco + "</td>" +
				"<td>" + p.categoria.nome + "</td>" +
				"<td>" +
					"<button class='btn btn-xs btn-primary' onclick='editar(" + p.id + ")'>Editar</button>" + 
					"<button class='btn btn-xs btn-danger ml-2' onclick='remover(" + p.id + ")'>Apagar</button>" + 
				"</td>" +
				"</tr>";
				return linha;
		}

		function carregarProdutos() {
			$.getJSON('/api/produtos', function(produtos) {
				for(i=0;i<produtos.length; i++) {
					linha = montarLinha(produtos[i])
					$('#tabProdutos>tbody').append(linha)

				}
			});
		}

		function criarProduto() {
			prod = {
				nome: $("#nomeProduto").val(),
				preco: 	$('#precoProduto').val(),
				estoque: $('#quantProduto').val(),
				categoria_id: $('#catProduto').val()
			}

			$.post("/api/produtos", prod, function(data) {
				produto = JSON.parse(data);
				linha = montarLinha(produto);
				$('#tabProdutos>tbody').append(linha)
			});
		}

		function editar(id) {
			$.getJSON('/api/produtos/'+id, function(produtos) {
			$ ('#id').val(produtos.id);
			$('#nomeProduto').val(produtos.nome);
			$('#precoProduto').val(produtos.preco);
			$('#quantProduto').val(produtos.estoque);
			$('#catProduto').val(produtos.categoria_id);
			$('#dlgProd').modal('show');
			});
		}

		function remover(id) {
			$.ajax({
				type: "DELETE",
				url: "/api/produtos/" + id,
				context : this,
				success: function () {
					linhas = $("#tabProdutos>tbody>tr")
					e = linhas.filter( function(i, elemento) {
						return elemento.cells[0].textContent == id;
					});
					if (e) 
						e.remove()

				},
				error: function (error) {
					console.log(error)
				}
			})
		}

		function salvarProduto() {
			prod = {
				id: $("#id").val(),
				nome: $("#nomeProduto").val(),
				preco: 	$('#precoProduto').val(),
				estoque: $('#quantProduto').val(),
				categoria_id: $('#catProduto').val()
			};

			$.ajax({
				type: "PUT",
				url: "/api/produtos/" + prod.id,
				context : this,
				data: prod,
				success: function (data) {
					prod = JSON.parse(data)
					linhas = $('#tabProdutos>tbody>tr');
					e = linhas.filter( function(i, e) {
						return ( e.cells[0].textContent == prod.id);
					});
					if (e) {
						e[0].cells[0].textContent = prod.produto.id;
						e[0].cells[1].textContent = prod.produto.nome;
						e[0].cells[2].textContent = prod.produto.estoque;
						e[0].cells[3].textContent = prod.produto.preco;
						e[0].cells[4].textContent = prod.nome;

					}
				},
				error: function (error) {
					console.log(error)
				}
			})
		}

		$('#FormProduto').submit( function(event) {
			event.preventDefault(); 
			if ($('#id').val() != '')
				salvarProduto()
			else
				criarProduto();
				$('#dlgProd').modal('hide')
		})

		$(function () {
			carregarProdutos();
			carregarCategorias();
		})


	</script>
@endsection