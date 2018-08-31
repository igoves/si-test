<h1 class="mt-2">
    List
    <span class="float-sm-right">
            <small class="text-muted" style="font-size:18px;">
                Avg <label class="badge badge-pill badge-secondary mr-1">Sociability {{ number_format($avg->s,2)  }}</label>
                <label class="badge badge-pill badge-secondary mr-1">Engineering Skill {{ number_format($avg->e,2)  }}</label>
                <label class="badge badge-pill badge-secondary mr-1">Time Management {{ number_format($avg->t,2)  }}</label>
                <label class="badge badge-pill badge-secondary">Knowledge Of Languages {{ number_format($avg->k,2) }}</label>
            </small>
        </span>
</h1>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover ">
        <thead>
        <tr>
            <th style="width: 80px">Photo</th>
            <th>Full Name</th>
            <th>Characteristics</th>
            <th>Projects</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        @if($users->count() === 0 )
            <tr>
                <td colspan="5" class="text-center">
                    Nothing to found
                </td>
            </tr>
        @else
            @foreach ( $users as $user )
                <tr>
                    <td class="align-middle text-center">
                        <img src="{{ $user->photo ? '/uploads/photos/'.$user->photo : 'https://via.placeholder.com/80x80?text=No photo' }}" alt="{{ $user->name }}">
                    </td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col-sm-5 ">
                                Sociability
                            </div>
                            <div class="col-sm-7">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $user->sociability*10 }}%" aria-valuenow="{{ $user->sociability*10 }}" aria-valuemin="{{ $user->sociability*10 }}" aria-valuemax="100">{{ $user->sociability }}</div>
                                </div>
                            </div>
                            <div class="col-sm-5 ">
                                Engineering Skill
                            </div>
                            <div class="col-sm-7">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $user->engineering_skill*10 }}%" aria-valuenow="{{ $user->engineering_skill*10 }}" aria-valuemin="{{ $user->engineering_skill*10 }}" aria-valuemax="100">{{ $user->engineering_skill }}</div>
                                </div>
                            </div>
                            <div class="col-sm-5 ">
                                Time Management
                            </div>
                            <div class="col-sm-7">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $user->time_management*10 }}%" aria-valuenow="{{ $user->time_management*10 }}" aria-valuemin="{{ $user->time_management*10 }}" aria-valuemax="100">{{ $user->time_management }}</div>
                                </div>
                            </div>
                            <div class="col-sm-5 ">
                                Knowledge Of Languages
                            </div>
                            <div class="col-sm-7">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $user->knowledge_of_languages*10 }}%" aria-valuenow="{{ $user->knowledge_of_languages*10 }}" aria-valuemin="{{ $user->knowledge_of_languages*10 }}" aria-valuemax="100">{{ $user->knowledge_of_languages }}</div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        {{ count($user->projects)  }}
                    </td>
                    <td class="align-middle">
                        <button type="button" class="btn btn-outline-primary" onclick="siModule.userEdit({{ $user->id }})">Edit</button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
