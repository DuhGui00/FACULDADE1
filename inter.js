// Espera o documento carregar
document.addEventListener('DOMContentLoaded', function() {

    // --- Requisito 1: Cálculo de Idade Automático ---
    const campoNascimento = document.getElementById('nascimento');
    const campoIdade = document.getElementById('idade');

    if (campoNascimento) {
        campoNascimento.addEventListener('input', function() {
            if (this.value) {
                const dataNasc = new Date(this.value);
                const hoje = new Date();
                let idade = hoje.getFullYear() - dataNasc.getFullYear();
                const mes = hoje.getMonth() - dataNasc.getMonth();
                
                // Ajuste caso ainda não tenha feito aniversário este ano
                if (mes < 0 || (mes === 0 && hoje.getDate() < dataNasc.getDate())) {
                    idade--;
                }
                campoIdade.value = idade;
            }
        });
    }

    // --- Requisito 2: Adicionar Campos Dinâmicos (Experiência) ---
    const btnAddExp = document.getElementById('btn-add-exp');
    const containerExp = document.getElementById('experiencias-container');
    let expCount = 0;

    if (btnAddExp) {
        btnAddExp.addEventListener('click', function() {
            expCount++;
            
            // Criar o HTML para os novos campos
            const novoCampo = document.createElement('div');
            // Adicionei a classe 'exp-bloco' que criei no CSS
            novoCampo.classList.add('exp-bloco', 'mb-3');
            
            // Usamos nomes de array (ex: exp_cargo[]) para o PHP receber todos
            novoCampo.innerHTML = `
                <h5 class="mb-3">Experiência #${expCount}</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cargo</label>
                        <input type="text" class="form-control" name="exp_cargo[]" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Empresa</label>
                        <input type="text" class="form-control" name="exp_empresa[]" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Período (Ex: Jan/2020 - Dez/2022)</label>
                    <input type="text" class="form-control" name="exp_periodo[]">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição das Atividades</label>
                    <textarea class="form-control" name="exp_descricao[]" rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-danger btn-remover-exp">Remover</button>
            `;

            // Adicionar o novo bloco de campos ao container
            containerExp.appendChild(novoCampo);
        });
    }

    // Lógica para o botão "Remover"
    if (containerExp) {
        containerExp.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-remover-exp')) {
                // Remove o 'div' pai (o .exp-bloco) do botão clicado
                e.target.closest('.exp-bloco').remove();
            }
        });
    }

});