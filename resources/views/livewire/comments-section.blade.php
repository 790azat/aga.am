<div>
    <div class="col-12" style="background:#181818;">
        <div class="container py-3">

            <!-- ADD COMMENT -->
            @auth
            <section>
                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-10 col-xl-8">

                        <div class="card shadow-sm"
                             style="background:#1f1f1f;color:#eaeaea;border:1px solid #2a2a2a;">
                            <div class="card-body p-4">

                                <div class="d-flex align-items-start gap-3">
                                    <img loading="lazy"
                                        src="{{ storage_url(Auth::user()->avatar) }}"
                                        class="rounded-circle"
                                        width="65"
                                        height="65"
                                        alt="avatar">

                                    <div class="flex-grow-1">
                                        <h5 class="mb-3" style="color:#ffffff;">Add a comment</h5>

                                        <!-- Textarea -->
                                        <div class="mb-3">
                                            <textarea
                                                wire:model.defer="text"
                                                rows="4"
                                                placeholder="What is your view?"
                                                class="form-control"
                                                style="background:#181818;color:#eaeaea;border:1px solid #2a2a2a;"></textarea>
                                        </div>

                                        @error('text')
                                        <p class="text-danger small">{{ $message }}</p>
                                        @enderror

                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <button wire:click="cancel" class="btn btn-outline-secondary">
                                                Cancel
                                            </button>

                                            <button wire:click="send" wire:loading.attr="disabled" class="btn btn-danger">
                                                <span wire:loading.remove>
                                                    Send <i class="fas fa-long-arrow-alt-right ms-1"></i>
                                                </span>
                                                <span wire:loading>Sending...</span>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </section>
            @else
            <section>
                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-10 col-xl-8">
                        <div class="card shadow-sm" style="background:#1f1f1f;color:#eaeaea;border:1px solid #2a2a2a;">
                            <div class="card-body p-4 text-center">
                                <a href="{{ route('login') }}" class="btn btn-danger">Log in to leave a comment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endauth

            <!-- COMMENTS -->
            <section class="py-5">
                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-9 col-xl-7">

                        @foreach($comments as $comment)
                            <div class="d-flex gap-3 mb-4">
                                <img loading="lazy"
                                    src="{{ storage_url($comment->user->avatar) }}"
                                    class="rounded-circle"
                                    width="65"
                                    height="65"
                                    alt="avatar">

                                <div class="card flex-grow-1"
                                     style="background:#1f1f1f;color:#eaeaea;border:1px solid #2a2a2a;">
                                    <div class="card-body p-4">
                                        <h5 class="mb-1" style="color:#ffffff;">{{ $comment->user->name }}</h5>

                                        <p class="small mb-2" style="color:#9a9a9a;">
                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y - H:i') }}
                                        </p>

                                        <p>{{ $comment->text }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
