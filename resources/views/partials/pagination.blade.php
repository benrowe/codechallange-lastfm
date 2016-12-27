@if ($resultSet->currentPage() > 1)
    <a href="{{$url}}page={{ $resultSet->currentPage() - 1 }}">Prev</a>
@endif
Page {{ $resultSet->currentPage() }} of {{ $resultSet->totalPages() }}

@if ($resultSet->currentPage() < $resultSet->totalPages())
    <a href="{{$url}}page={{  $resultSet->currentPage() + 1 }}">Next</a>
@endif