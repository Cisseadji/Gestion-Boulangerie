import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CommandeEmployeComponent } from './commande-employe.component';

describe('CommandeEmployeComponent', () => {
  let component: CommandeEmployeComponent;
  let fixture: ComponentFixture<CommandeEmployeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [CommandeEmployeComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(CommandeEmployeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
