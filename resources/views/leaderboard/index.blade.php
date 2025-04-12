<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Leaderboard</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
    <body>

    <div class="container mt-5">

        <h1 class="text-center mb-4"> <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{route('leaderboard.index')}}">Leaderboard</a></h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters and Search --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <form method="GET" action="{{ route('leaderboard.index') }}">
                    <div class="input-group">
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="">All Time</option>
                            <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Today</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <form method="GET" action="{{ route('leaderboard.index') }}">
                    <div class="input-group">
                        <input type="text" name="search_id" class="form-control" placeholder="Search by User ID" value="{{ request('search_id') }}">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <div class="col-md-4 text-end">
                <form action="{{ route('leaderboard.recalculate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning">🔄 Recalculate</button>
                </form>
            </div>
        </div>

        {{-- Leaderboard Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="leaderboardTable">
                <thead class="table-dark">
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Total Points</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr @if(request('search_id') == $user->id) class="table-success" @endif>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->total_points }}</td>
                            <td>{{ $user->rank }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- DataTables Init --}}
    <script>
        $(document).ready(function () {
            $('#leaderboardTable').DataTable({
                searching: false,
                order: []
            });
        });
    </script>

    </body>
</html>
