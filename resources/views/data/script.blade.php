<script>

/* =========================================================
   FILTER
========================================================= */

function toggleFilter()
{
    const filterBox =
        document.getElementById('filterBox');

    filterBox.classList.toggle('show');
}


/* =========================================================
   ADD MODAL
========================================================= */

function openAddModal()
{
    const modal =
        document.getElementById('addDataModal');

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeAddModal()
{
    const modal =
        document.getElementById('addDataModal');

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/* =========================================================
   EDIT MODAL
========================================================= */

function openEditModal(
    id,
    namaDataset,
    jenisData,
    tahun,
    fileData
)
{
    const modal =
        document.getElementById('editDataModal');

    const form =
        document.getElementById('editDataForm');

    const nama =
        document.getElementById('edit_nama_dataset');

    const jenis =
        document.getElementById('edit_jenis_data');

    const tahunInput =
        document.getElementById('edit_tahun');

    const currentFile =
        document.getElementById('edit_current_file');

    const fileLink =
        document.getElementById('edit_file_link');


    /*
     * ACTION UPDATE
     */

    form.action =
        "{{ url('/data') }}/" + id;


    /*
     * ISI FORM
     */

    nama.value =
        namaDataset;

    jenis.value =
        jenisData;

    tahunInput.value =
        tahun;


    /*
     * FILE LAMA
     */

    if(fileData)
    {

        currentFile.style.display =
            'flex';

        fileLink.href =
            "{{ asset('storage') }}/" + fileData;

    }
    else
    {

        currentFile.style.display =
            'none';

        fileLink.href =
            '#';

    }


    /*
     * TAMPILKAN MODAL
     */

    modal.classList.add('show');

    document.body.style.overflow =
        'hidden';
}


function closeEditModal()
{
    const modal =
        document.getElementById('editDataModal');

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/* =========================================================
   COMMENT
========================================================= */

function showComment(comment)
{
    const modal =
        document.getElementById('commentModal');

    const text =
        document.getElementById('commentText');

    text.textContent =
        comment;

    modal.classList.add('show');

    document.body.style.overflow =
        'hidden';
}


function closeCommentModal()
{
    const modal =
        document.getElementById('commentModal');

    modal.classList.remove('show');

    document.body.style.overflow =
        '';
}


/* =========================================================
   CLICK OUTSIDE MODAL
========================================================= */

window.addEventListener(
    'click',
    function(event)
    {

        const addModal =
            document.getElementById('addDataModal');

        const editModal =
            document.getElementById('editDataModal');

        const commentModal =
            document.getElementById('commentModal');


        if(event.target === addModal)
        {
            closeAddModal();
        }


        if(event.target === editModal)
        {
            closeEditModal();
        }


        if(event.target === commentModal)
        {
            closeCommentModal();
        }

    }
);


/* =========================================================
   ESC KEY
========================================================= */

window.addEventListener(
    'keydown',
    function(event)
    {

        if(event.key === 'Escape')
        {

            closeAddModal();

            closeEditModal();

            closeCommentModal();

        }

    }
);

</script>