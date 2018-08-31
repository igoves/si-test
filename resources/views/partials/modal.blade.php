<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form class="needs-validation" id="ajaxForm" action="{{ $route }}" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="FullName">Full Name</label>
                        <input type="text" name="name" class="form-control" id="FullName" placeholder="Full Name" value="{{ $user->name or '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Photo">Photo</label>
                        @if ( $route === '/edit' && $user->photo )
                            <div id="photo_block">
                                <img src="/uploads/photos/{{ $user->photo }}" alt="{{ $user->name }}" />
                                <button type="button" onclick="siModule.removePhoto({{ $user->id }})" class="btn btn-sm btn-danger ml-1">x</button>
                            </div>
                        @else
                            <input type="file" name="photo" class="form-control-file" id="Photo" placeholder="Photo" value="">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="Sociability">Sociability</label>
                        <select class="custom-select d-block w-100" id="Sociability" name="sociability">
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ isset($user->sociability) && $user->sociability === $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="EngineeringSkill">Engineering Skill</label>
                        <select class="custom-select d-block w-100" id="EngineeringSkill" name="engineering_skill">
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ isset($user->engineering_skill) && $user->engineering_skill === $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="TimeManagement">Time Management</label>
                        <select class="custom-select d-block w-100" id="TimeManagement" name="time_management" onchange="siModule.timeManagement(this)">
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ isset($user->time_management) && $user->time_management === $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="KnowledgeOfLanguages">Knowledge Of Languages</label>
                        <select class="custom-select d-block w-100" id="KnowledgeOfLanguages" name="knowledge_of_languages">
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ isset($user->knowledge_of_languages) && $user->knowledge_of_languages === $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Project">Project(s) <small>(Use Time Management = 10 to get more projects)</small></label>
                    <select class="custom-select d-block w-100" id="Project" name="projects[]" multiple>
                        <option value="">Choose...</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ isset($projects_ids) && in_array($project->id, $projects_ids)  ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                @if ( $route === '/edit' )
                    <input type="hidden" name="photo" value="{{ $user->photo }}" />
                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">OK</button>
                {{ csrf_field() }}
            </div>
        </form>
    </div>
</div>
