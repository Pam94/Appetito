import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ShoplistComponent } from './components/shoplist/shoplist.component';

const routes: Routes = [
  { path: 'shoplist', component: ShoplistComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ShoplistRoutingModule { }
