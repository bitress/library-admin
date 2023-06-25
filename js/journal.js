$(document).ready(function(){
    var notyf = new Notyf();

    function generateTemplate(res){

        var template =  '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
        template +=  '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">'+ res.journalID +'</th>';
        template +=  '<td class="px-6 py-4">'+ res.journalname +'</td>';
        template +=  '<td class="px-6 py-4">'+ res.description +'</td>';
        template +=  '<td class="px-6 py-4"><a href="'+ res.url +'" target="_blank">'+ res.url +'</a> </td>';
        template +=  '<td class="px-6 py-4"><img src="'+ res.imageurl +'" height="50px" width="50px" alt="'+ res.journalname +'"></td>';
        template +=  '<td class="px-6 py-4">'+ res.dateposted +'</td>';
        template +=  '<td class="px-6 py-4 text-right"><a data-modal-target="defaultModal" data-modal-toggle="defaultModal"  class="font-medium text-blue-600 dark:text-blue-500 hover:underline edit" data-id="'+ res.journalID +'" onclick="toggleModal(\'modal-id\')">Edit</a></td>';
        template +=  '</tr>';

        return $(template);

    }

    function initJournalTable() {
        $.ajax({
            type: 'POST',
            url: 'manage-journals/fetch-journals.php',
            success: function (res){
                var data = JSON.parse(res);
                var $output = $();
                for(var i=0; i<data.journal.length; i++) {
                    $output = $output.add(generateTemplate(data.journal[i]));
                }
                $("#journals_view").html($output);

            }
        })
    }

    initJournalTable()



    // Change Journal Image Preview on text input field change
    $('#journal_image').on('input',function(e){
        $("#image_preview").attr("src",this.value);
    });


    // Fetch the journal data
    $(document).on('click', '.edit', function (){

        let journal_id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'manage-journals/fetch-journal-data.php',
            data: {journal_id: journal_id},
            success: function (res) {

                var data = JSON.parse(res)
                $("#journal_name").val(data.journalname);
                $("#journalID").val(data.journalID);
                $("#journal_description").val(data.description);
                $("#journal_url").val(data.url);
                $("#journal_image").val(data.imageurl);
                $("#image_preview").attr("src",data.imageurl);

            }
        })


    });

    $("#save_journal_edit").on('click', function(e) {

        var data = {
            journalname: $("#journal_name").val(),
            journalID:  $("#journalID").val(),
            description: $("#journal_description").val(),
            url: $("#journal_url").val(),
            imageurl: $("#journal_image").val()
        };


        $.ajax({
            type: "POST",
            url: "manage-journals/edit-journal.php",
            data: {
                journalID: data.journalID,
                journalname: data.journalname,
                description: data.description,
                url: data.url,
                imageurl: data.imageurl
            },
            success: function(res){
                if (res === "true"){
                    notyf.success('Your changes have been successfully saved!');
                    initJournalTable();
                } else {
                    notyf.error(res)
                }
            }
        })

    });

    $("#save_journal").on('click', function(e) {

        var data = {
            journalname: $("#add_journal_name").val(),
            description: $("#add_journal_description").val(),
            url: $("#add_journal_url").val(),
            imageurl: $("#add_journal_image").val()
        };


        $.ajax({
            type: "POST",
            url: "manage-journals/add-journal.php",
            data: {
                journalname: data.journalname,
                description: data.description,
                url: data.url,
                imageurl: data.imageurl
            },
            success: function(res){
                if (res === "true"){
                    notyf.success('Journal have been successfully saved!');
                    initJournalTable();
                } else {
                    notyf.error(res)
                }
            }
        })

    });
})