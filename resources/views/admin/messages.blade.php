@extends("admin.layout")
@section("content")
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; font-size: 1.8em; letter-spacing: -0.5px;" class="i18n" data-en="Contact Messages" data-ar="رسائل التواصل">Contact Messages</h1>
</div>

<?php if (session('success')): ?>
    <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 15px 20px; margin-bottom: 25px; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; gap: 10px; font-weight: 500;">
        <i class="fa-solid fa-check-circle" style="font-size: 1.2em;"></i> <?= htmlspecialchars(session('success')) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); gap: 25px; width: 100%;">
    <?php if($messages->isEmpty()): ?>
        <div style="background: rgba(255,255,255,0.02); padding: 40px; text-align: center; border-radius: 16px; border: 1px dashed var(--border-color);">
            <i class="fa-solid fa-inbox" style="font-size: 3em; color: var(--text-muted); margin-bottom: 15px;"></i>
            <p style="color: var(--text-muted); font-size: 1.1em; margin: 0;" class="i18n" data-en="No messages found." data-ar="لا توجد رسائل حالياً.">No messages found.</p>
        </div>
    <?php else: ?>
        <?php foreach($messages as $msg): ?>
            <?php 
                $id = $msg->id ?? $msg['id'];
                $date = isset($msg['created_at']) ? $msg['created_at']->format('M d, Y - H:i') : '';
            ?>
            <div class="project-item" style="border-left: 4px solid var(--accent-color); padding: 25px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h3 style="margin: 0 0 8px 0; color: var(--text-main); display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <?= htmlspecialchars($msg['name'] ?? '') ?>
                        </h3>
                        <div style="display: flex; gap: 15px; color: var(--text-muted); font-size: 0.9em; flex-wrap: wrap; margin-left: 46px;">
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-envelope" style="color: var(--accent-color);"></i> 
                                <a href="mailto:<?= htmlspecialchars($msg['email'] ?? '') ?>" style="color: inherit; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--text-main)'" onmouseout="this.style.color='inherit'"><?= htmlspecialchars($msg['email'] ?? '') ?></a>
                            </span>
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-clock" style="opacity: 0.7;"></i> <?= $date ?>
                            </span>
                        </div>
                    </div>
                    <a href="/admin/messages?action=delete&id=<?= $id ?>" onclick="confirmDelete(event, this.href, document.documentElement.lang === 'ar' ? 'هل أنت متأكد من مسح هذه الرسالة؟' : 'Are you sure you want to delete this message?');" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-color: rgba(239, 68, 68, 0.2); padding: 8px 12px;" title="Delete Message">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
                
                <div style="background: rgba(0, 0, 0, 0.2); padding: 20px; border-radius: 12px; margin-top: 20px; margin-left: 46px; border: 1px solid rgba(255,255,255,0.03); line-height: 1.6; white-space: pre-wrap; font-size: 0.95em; color: var(--text-main); position: relative;">
                    <i class="fa-solid fa-quote-left" style="position: absolute; top: -10px; left: 15px; color: var(--bg-secondary); background: var(--text-muted); border-radius: 50%; padding: 5px; font-size: 0.7em;"></i>
                    <?= htmlspecialchars($msg['message'] ?? '') ?>
                </div>
                
                <?php if(!empty($msg['voice_path'])): ?>
                    <div style="margin-top: 20px; margin-left: 46px; background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.1); border-radius: 50px; padding: 10px 20px; display: inline-flex; align-items: center; gap: 15px;">
                        <i class="fa-solid fa-microphone-lines" style="color: #3b82f6; font-size: 1.2em;"></i>
                        <audio controls src="/storage/<?= htmlspecialchars($msg['voice_path']) ?>" style="height: 30px; outline: none;"></audio>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
@endsection
