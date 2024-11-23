// Configuração da API
const API_URL = 'http://localhost/api';

// DataTables
let clientesTable;
let pedidosTable;

// Inicialização
$(document).ready(function() {
    initializeTables();
    loadClientes();
    loadPedidos();
});

// Inicializar DataTables
function initializeTables() {
    clientesTable = $('#clientesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
        }
    });

    pedidosTable = $('#pedidosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
        }
    });
}

// Funções de navegação
function showClientes() {
    $('#clientesSection').show();
    $('#pedidosSection').hide();
}

function showPedidos() {
    $('#clientesSection').hide();
    $('#pedidosSection').show();
}

// CRUD Clientes
async function loadClientes() {
    try {
        const response = await fetch(`${API_URL}/clientes`);
        const clientes = await response.json();
        
        clientesTable.clear();
        clientes.forEach(cliente => {
            clientesTable.row.add([
                cliente.id,
                cliente.nome,
                cliente.email,
                cliente.telefone,
                `<button class="btn btn-sm btn-warning" onclick="editCliente(${cliente.id})">Editar</button>
                 <button class="btn btn-sm btn-danger" onclick="deleteCliente(${cliente.id})">Excluir</button>`
            ]);
        });
        clientesTable.draw();
        
        // Atualizar select de clientes no modal de pedidos
        const select = $('#pedidoClienteId');
        select.empty();
        clientes.forEach(cliente => {
            select.append(`<option value="${cliente.id}">${cliente.nome}</option>`);
        });
    } catch (error) {
        console.error('Erro ao carregar clientes:', error);
        alert('Erro ao carregar clientes');
    }
}

function showClienteModal(cliente = null) {
    $('#clienteId').val(cliente?.id || '');
    $('#clienteNome').val(cliente?.nome || '');
    $('#clienteEmail').val(cliente?.email || '');
    $('#clienteTelefone').val(cliente?.telefone || '');
    $('#clienteModal').modal('show');
}

async function saveCliente() {
    const cliente = {
        nome: $('#clienteNome').val(),
        email: $('#clienteEmail').val(),
        telefone: $('#clienteTelefone').val()
    };

    const id = $('#clienteId').val();
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/clientes/${id}` : `${API_URL}/clientes`;

    try {
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(cliente)
        });

        if (response.ok) {
            $('#clienteModal').modal('hide');
            loadClientes();
        } else {
            alert('Erro ao salvar cliente');
        }
    } catch (error) {
        console.error('Erro ao salvar cliente:', error);
        alert('Erro ao salvar cliente');
    }
}

async function deleteCliente(id) {
    if (!confirm('Deseja realmente excluir este cliente?')) return;

    try {
        const response = await fetch(`${API_URL}/clientes/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            loadClientes();
        } else {
            alert('Erro ao excluir cliente');
        }
    } catch (error) {
        console.error('Erro ao excluir cliente:', error);
        alert('Erro ao excluir cliente');
    }
}

// CRUD Pedidos
async function loadPedidos() {
    try {
        const response = await fetch(`${API_URL}/pedidos`);
        const pedidos = await response.json();
        
        pedidosTable.clear();
        pedidos.forEach(pedido => {
            pedidosTable.row.add([
                pedido.id,
                pedido.cliente_nome,
                pedido.descricao,
                `R$ ${parseFloat(pedido.valor).toFixed(2)}`,
                pedido.status,
                `<button class="btn btn-sm btn-warning" onclick="editPedido(${pedido.id})">Editar</button>
                 <button class="btn btn-sm btn-danger" onclick="deletePedido(${pedido.id})">Excluir</button>`
            ]);
        });
        pedidosTable.draw();
    } catch (error) {
        console.error('Erro ao carregar pedidos:', error);
        alert('Erro ao carregar pedidos');
    }
}

function showPedidoModal(pedido = null) {
    $('#pedidoId').val(pedido?.id || '');
    $('#pedidoClienteId').val(pedido?.cliente_id || '');
    $('#pedidoDescricao').val(pedido?.descricao || '');
    $('#pedidoValor').val(pedido?.valor || '');
    $('#pedidoStatus').val(pedido?.status || 'pendente');
    $('#pedidoModal').modal('show');
}

async function savePedido() {
    const pedido = {
        cliente_id: $('#pedidoClienteId').val(),
        descricao: $('#pedidoDescricao').val(),
        valor: $('#pedidoValor').val(),
        status: $('#pedidoStatus').val()
    };

    const id = $('#pedidoId').val();
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/pedidos/${id}` : `${API_URL}/pedidos`;

    try {
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pedido)
        });

        if (response.ok) {
            $('#pedidoModal').modal('hide');
            loadPedidos();
        } else {
            alert('Erro ao salvar pedido');
        }
    } catch (error) {
        console.error('Erro ao salvar pedido:', error);
        alert('Erro ao salvar pedido');
    }
}

async function deletePedido(id) {
    if (!confirm('Deseja realmente excluir este pedido?')) return;

    try {
        const response = await fetch(`${API_URL}/pedidos/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            loadPedidos();
        } else {
            alert('Erro ao excluir pedido');
        }
    } catch (error) {
        console.error('Erro ao excluir pedido:', error);
        alert('Erro ao excluir pedido');
    }
} 