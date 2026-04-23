=== Plugin Info ===
Setup My Technology
Repo: simplifybiz-smt

Custom plugin for the Setup My Technology site. Built on the SMPLFY
boilerplate architecture (Repositories / Usecases / Adapters).

Depends on: smplfy-core

=== Features ===
- Get An Estimate form submission handling (Gravity Forms form 3)
- Job Master Form submission handling (Gravity Forms form 6)
- Webhook notification on every submission
- Entity mapping for all SMT form fields

=== Architecture ===
smplfy-smt.php                    Main plugin file / entry point
admin/DependencyFactory.php       Wires up dependencies
admin/utilities/                  Require helpers (generic)
includes/smplfy_bootstrap.php     Loads files + kicks off factory
public/php/types/                 FormIds (reference data)
public/php/entities/              GetAnEstimateEntity, JobMasterEntity
public/php/repositories/          GetAnEstimateRepository, JobMasterRepository
public/php/usecases/              GoogleChatNotification (business logic)
public/php/adapters/              GravityFormsAdapter (hooks GF -> usecases)
