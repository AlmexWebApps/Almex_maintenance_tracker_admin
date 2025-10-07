# ... (después de la línea COPY docker/php/php.ini)

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# ... (resto del archivo)

# Cambiar el CMD por:
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
