<!-- Modal -->
<div class="modal fade" id="modalUserInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit User Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo do formulário ou informações do usuário -->
                <form id="user-form">
                    <!-- Adicione os campos necessários aqui -->
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                        </div>
                    </div>

                    <!-- Outros campos conforme necessário -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id='btnEdit'>Edit</button>
                <button type="button" class="btn btn-primary" id="saveUserInfo">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#modalUserInfo').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget); // Botão que acionou o modal
            let userId = button.data('user-id'); // Obtém o ID do usuário do botão
            // Faz a chamada AJAX para obter os dados do usuário
            $.ajax({
                url: '/localloop/frontend/web/user-info/get-user-info',
                method: 'GET',
                data: {
                    id: userId
                },
                success: function(data) {
                    // Preencher os campos do modal com os dados do usuário
                    $('#username').data('userId', userId);

                    $('#username').val(data.username).addClass('readOnly').attr('readonly', true); // Preenchendo o campo de nome de usuário
                    $('#email').val(data.email).addClass('readOnly').attr('readonly', true); // Preenchendo o campo de e-mail
                    $('#name').val(data.name).addClass('readOnly').attr('readonly', true); // Preenchendo o campo de e-mail
                    $('#address').val(data.address).addClass('readOnly').attr('readonly', true); // Preenchendo o campo de e-mail
                    $('#postal_code').val(data.postal_code).addClass('readOnly').attr('readonly', true); // Preenchendo o campo de e-mail
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching user data: ', error);
                    // Aqui você pode exibir uma mensagem de erro, se necessário
                    alert('Erro ao buscar os dados do usuário.');
                }
            });
        });
    });

    $('#saveUserInfo').click(function() {
        // Faz a chamada AJAX para obter os dados do usuário
        let userId = $('#username').data('userId');
        let userData = $('#user-form').serialize()
        $.ajax({
            url: '/localloop/frontend/web/user-info/save-user-info',
            method: 'POST',
            dataType: 'json',
            data: {
                id: userId,
                userData: userData
            },
            success: function(response) {
                if (response.success) {
                    $('#modalUserInfo').modal('hide'); // Fechar modal ao salvar com sucesso
                    $('#logoutUsername').text(response.username) // caso o username seja alterado altera o texto no logout
                    $('#toastMessage').text('Information updated with success!')
                    showToast();
                } else {
                    // Mostra os erros
                    let errorMessage = '';

                    Object.keys(response.errors).forEach(function(field) {
                        const messages = response.errors[field];
                        messages.forEach(function(message) {
                            errorMessage += `${message} <br>`;
                        });
                    });
                    $('#modalErrorMessage').html(errorMessage);
                    $('#modalError').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data: ', error);
                // Aqui você pode exibir uma mensagem de erro, se necessário
                alert('Erro ao buscar os dados do usuário.');
            }
        });
    })

    $('#btnEdit').click(function() {
        $('#username').removeClass('readOnly').removeAttr('readonly');
        $('#email').removeClass('readOnly').removeAttr('readonly');
        $('#name').removeClass('readOnly').removeAttr('readonly');
        $('#address').removeClass('readOnly').removeAttr('readonly');
        $('#postal_code').removeClass('readOnly').removeAttr('readonly');
    })
</script>