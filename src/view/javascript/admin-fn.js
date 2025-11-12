
document.addEventListener('DOMContentLoaded', function() {
    // Navegação por abas
    document.querySelectorAll('.side[data-tab] a').forEach(link => {
        link.addEventListener('click', function(e) {
            const tab = this.closest('.side').getAttribute('data-tab');
            document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
            document.getElementById(tab).style.display = 'block';
            document.querySelectorAll('.side').forEach(s => s.classList.remove('active'));
            this.closest('.side').classList.add('active');
        });
    });

    // Gráfico
    const ctx = document.getElementById('categoryChart')?.getContext('2d');
    if (ctx) {
        const labels = <?php echo json_encode(
            array_keys($categoriaCount),
        ); ?>;
        const data = <?php echo json_encode(
            array_values($categoriaCount),
        ); ?>;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels.length ? labels : ['Sem Dados'],
                datasets: [{
                    data: data.length ? data : [1],
                    backgroundColor: labels.length ? ['#eb4a4a', '#ff7961', '#ff9e80', '#ffb74d', '#ffd180'] : ['#ccc'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // Preencher modal de edição de Post
    const editarPostModal = document.getElementById('editarPostModal');
    editarPostModal?.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const pid = button.getAttribute('data-id') || '';
        document.getElementById('editarPostID').value = pid;
        document.getElementById('editarTitulo').value = button.getAttribute('data-titulo') || '';
        document.getElementById('editarIngredientes').value = button.getAttribute('data-ingredientes') || '';
        document.getElementById('editarModo').value = button.getAttribute('data-modo') || '';
        const cat = button.getAttribute('data-categoria') || '';
        const sel = document.getElementById('editarCategoria');
        if (sel) sel.value = cat;
        // load imagens
        document.getElementById('editarImgsPostID').value = pid;
        const list = document.getElementById('editarImagensList');
        list.innerHTML = '<span class="text-muted">Carregando imagens...</span>';
        try {
          const resp = await fetch(`../controller/PostImageController.php?action=list&postID=${pid}`);
          const data = await resp.json();
          if (!data.ok) throw new Error();
          list.innerHTML = '';
          data.items.forEach(img => {
            const wrap = document.createElement('div');
            wrap.className = 'position-relative';
            wrap.style.width = '96px';
            wrap.style.height = '96px';
            wrap.innerHTML = `
              <img src="${img.b64}" class="rounded border" style="object-fit:cover;width:96px;height:96px;"/>
              <form action="../controller/PostImageController.php" method="POST" class="position-absolute" style="top:2px; right:2px;">
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="post_imagesID" value="${img.id}" />
                <input type="hidden" name="redirect" value="../view/painel.php?tab=postagens" />
                <button class="btn btn-sm btn-danger" title="Remover" onclick="return confirm('Remover esta imagem?')">&times;</button>
              </form>`;
            list.appendChild(wrap);
          });
        } catch (e) {
          list.innerHTML = '<span class="text-danger">Falha ao carregar imagens.</span>';
        }
    });
});
const editModal = document.getElementById('modalEditUser');
    editModal?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userID = button.getAttribute('data-userid');
        const username = button.getAttribute('data-username');
        const email = button.getAttribute('data-email');
        const isAdmin = parseInt(button.getAttribute('data-isadmin'), 10) === 1;

        document.getElementById('editUserID').value = userID;
        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPassword').value = '';
        document.getElementById('editIsAdmin').checked = isAdmin;
    });
});
