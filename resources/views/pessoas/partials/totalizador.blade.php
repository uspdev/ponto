            <div class="table-responsive">
              <table class="table table-sm table-hover">
                  <thead class="table-warning">
                    <tr>
                      <th colspan="2">Totalizador</th>
                    </tr>
                  </thead>
                  <tbody style="font-size: 0.85em;">
                    <tr>
                      <td>Jornada semanal <span class="text-secondary font-italic">(horas)</span></td>
                      <td class="text-right">{{ $totalizador['carga_horaria_semanal'] }}</td>
                    </tr>
                    <tr>
                      <td>Dias úteis <span class="text-secondary font-italic">(dias)</span></td>
                      <td class="text-right">{{ $totalizador['quantidade_dias_uteis'] }}</td>
                    </tr>
                    <tr>
                      <td>Dias registrados <span class="text-secondary font-italic">(dias)</span></td>
                      <td class="text-right">{{ $totalizador['quantidade_dias_registrados'] }}</td>
                    </tr>                    
                    <tr>
                      <td>Jornada mensal <span class="text-secondary font-italic">(horas)</span></td>
                      <td class="text-right">{{ $totalizador['carga_horaria_total'] }}</td>
                    </tr>
                    <tr>
                      <td>Total registrado</td>
                      <td class="text-right">{{ $totalizador['total_registrado'] }}</td>
                    </tr>  
                    <tr>
                      <td>Saldo</td>
                      <td class="text-right"><span @if ($total < $totalizador['carga_horaria_total']) class="text-danger" @endif>{{ $totalizador['saldo'] }}</span></td>
                    </tr>                                      
                  </tbody>                    
              </table>
            </div>