<!DOCTYPE html>
<html>
<head>
    <title>Momen invoices </title>
</head>
<body>
    <h3>تم اضافة قاتورة جديدة  </h3>
    <p>  {{ $invoices_id }}   : رقم الفاتورة </p>
    <div> 
        <button href="{{ route('Print_invoice', $invoices_id ) }}"  class="btn btn-primary" type="submit"> عرض الفاتورة </button>
    </div>
</body>
</html>
