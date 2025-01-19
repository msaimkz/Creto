<table>
    <thead>
        <tr>
            <th style="font-weight: bold;">ID</th>
            <th style="font-weight: bold;">Name</th>
            <th style="font-weight: bold;">Email</th>
            <th style="font-weight: bold;">Phone</th>
            <th style="font-weight: bold;">Country</th>
            <th style="font-weight: bold;">Registration Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        @php
          $country = country($user->country_id)
        @endphp
        <tr>
            <td>
                {{ $user->id }}
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ($user->mobile != null) ? $user->mobile : '' }}</td>
            <td>{{ ($country != null) ? $country->name : '' }}</td>
            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>