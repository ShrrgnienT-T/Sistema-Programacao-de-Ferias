# Contributing

## Fluxo obrigatório antes de abrir/atualizar PR

Para evitar conflitos de merge e retrabalho, siga **sempre** esta ordem:

1. Garanta que sua branch local está limpa:
   ```bash
   git status
   ```
2. Atualize com a branch base remota:
   ```bash
   git pull --rebase origin <base-branch>
   ```
3. Se houver conflitos:
   - resolver arquivo por arquivo,
   - rodar testes,
   - continuar o rebase:
   ```bash
   git add <arquivos>
   git rebase --continue
   ```
4. Só então rode validações e faça push/PR.

## Checklist mínimo de qualidade

- `php artisan test`
- `./vendor/bin/pint`
- `npm run build`

## Observação importante

Se a branch não tiver `tracking` configurado, configure antes do pull:

```bash
git branch --set-upstream-to=origin/<branch> <branch>
```

Sem isso, `git pull --rebase` não funciona de forma previsível.
