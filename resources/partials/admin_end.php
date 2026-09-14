            </main>

            <footer class="admin-footer">
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <span>&copy; <?php echo date('Y'); ?> <?= htmlspecialchars($siteName ?? 'Courier Admin'); ?>. All rights reserved.</span>
                    <span>Logged in as <strong><?= htmlspecialchars($login_session ?? ''); ?></strong></span>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!empty($extraScripts)) echo $extraScripts; ?>
</body>

</html>
