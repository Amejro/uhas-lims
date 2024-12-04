@props(['result'])

<style>
    .lab-result-table {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .lab-result-table td {

        vertical-align: top;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #e2e8f0;
        padding: 2px;
        text-align: left;
    }



    th {
        background-color: #f8fafc;
        font-weight: 600;
    }
</style>

<div>

    <table class="lab-result-table">




        {!! tiptap_converter()->asHTML($result) !!}




    </table>
</div>



<!-- </html> -->