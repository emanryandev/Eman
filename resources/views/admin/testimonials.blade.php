@extends("admin.layout")
@section("content")
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; font-size: 1.8em; letter-spacing: -0.5px;" class="i18n" data-en="Testimonials Management" data-ar="إدارة آراء العملاء">Testimonials Management</h1>
</div>

<?php if (session('success')): ?>
    <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 15px 20px; margin-bottom: 25px; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; gap: 10px; font-weight: 500;">
        <i class="fa-solid fa-check-circle" style="font-size: 1.2em;"></i> <?= htmlspecialchars(session('success')) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); gap: 25px; width: 100%;">
    <?php if($testimonials->isEmpty()): ?>
        <div style="background: rgba(255,255,255,0.02); padding: 40px; text-align: center; border-radius: 16px; border: 1px dashed var(--border-color);">
            <i class="fa-solid fa-comment-slash" style="font-size: 3em; color: var(--text-muted); margin-bottom: 15px;"></i>
            <p style="color: var(--text-muted); font-size: 1.1em; margin: 0;" class="i18n" data-en="No testimonials found." data-ar="لا توجد آراء حالياً.">No testimonials found.</p>
        </div>
    <?php else: ?>
        <?php foreach($testimonials as $test): ?>
            <div class="project-item" style="border-left: 4px solid <?= $test->is_approved ? 'var(--accent-color)' : '#f59e0b' ?>; padding: 25px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h3 style="margin: 0 0 8px 0; color: var(--text-main); display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <?= htmlspecialchars($test->name) ?>
                        </h3>
                        <div style="display: flex; gap: 15px; color: var(--text-muted); font-size: 0.9em; flex-wrap: wrap; margin-left: 46px; align-items: center;">
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-briefcase" style="color: #8b5cf6;"></i> <?= htmlspecialchars($test->role) ?>
                            </span>
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-clock" style="opacity: 0.7;"></i> <?= $test->created_at->format('M d, Y - H:i') ?>
                            </span>
                            
                            <?php if($test->is_approved): ?>
                                <span style="display: inline-flex; align-items: center; gap: 4px; background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 0.85em; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600;">
                                    <i class="fa-solid fa-check-double"></i> Approved (Visible)
                                </span>
                            <?php else: ?>
                                <span style="display: inline-flex; align-items: center; gap: 4px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; padding: 4px 10px; border-radius: 20px; font-size: 0.85em; border: 1px solid rgba(245, 158, 11, 0.2); font-weight: 600;">
                                    <i class="fa-solid fa-hourglass-half"></i> Pending Review
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <?php if(!$test->is_approved): ?>
                            <form method="POST" action="<?= route('admin.testimonials.approve', $test->id) ?>" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border-color: rgba(16, 185, 129, 0.3); padding: 8px 15px; font-size: 0.9em; box-shadow: none;" title="Approve">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?= route('admin.testimonials.unapprove', $test->id) ?>" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border-color: rgba(245, 158, 11, 0.3); padding: 8px 15px; font-size: 0.9em; box-shadow: none;" title="Hide">
                                    <i class="fa-solid fa-eye-slash"></i> Hide
                                </button>
                            </form>
                        <?php endif; ?>

                        <form method="POST" action="<?= route('admin.testimonials.destroy', $test->id) ?>" onsubmit="confirmDelete(event, this, document.documentElement.lang === 'ar' ? 'هل أنت متأكد من مسح هذا الرأي؟' : 'Are you sure you want to delete this testimonial?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-color: rgba(239, 68, 68, 0.2); padding: 8px 12px; font-size: 0.9em; box-shadow: none;" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div style="background: rgba(0, 0, 0, 0.2); padding: 20px; border-radius: 12px; margin-top: 20px; margin-left: 46px; border: 1px solid rgba(255,255,255,0.03); line-height: 1.6; font-size: 0.95em; font-style: italic; color: var(--text-main); position: relative;">
                    <i class="fa-solid fa-quote-left" style="position: absolute; top: -10px; left: 15px; color: var(--bg-secondary); background: var(--text-muted); border-radius: 50%; padding: 5px; font-size: 0.7em;"></i>
                    "<?= htmlspecialchars($test->feedback) ?>"
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
@endsection
